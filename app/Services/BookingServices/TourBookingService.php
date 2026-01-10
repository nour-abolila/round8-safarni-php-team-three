<?php

namespace App\Services\BookingServices;

use App\Helper\ApiResponse;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\TourSchedule;
use App\Services\Payment\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TourBookingService
{
    public function __construct(protected PaymentService $paymentService) {}

    public function bookTour(array $data)
    {
        $user = Auth::user();
        $tour = Tour::find($data['tour_id']);
        if (!$tour) {
            return [
                'status' => 'error',
                'message' => 'الجولة المحددة غير موجودة',
                'statusCode' => 404
            ];
        }

        $schedule = TourSchedule::where('id', $data['tour_schedule_id'])
            ->where('tour_id', $data['tour_id'])
            ->first();

        if (!$schedule) {
            return [
                'status' => 'error',
                'message' => 'الموعد المحدد غير موجود لهذه الجولة',
                'statusCode' => 404
            ];
        }

        // Check available slots
        if ($schedule->available_slots < $data['quantity']) {
            return [
                'status' => 'error',
                'message' => 'عدد المقاعد المتاح غير كافي',
                'statusCode' => 400
            ];
        }

        // Calculate price
        $pricePerPerson = $tour->price;
        $totalAmount = $pricePerPerson * $data['quantity'];

        DB::beginTransaction();
        try {
            // Create Booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'booking_status' => 'pending',
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
            ]);

            // Create Booking Detail
            BookingDetail::create([
                'booking_id' => $booking->id,
                'bookable_type' => Tour::class,
                'bookable_id' => $tour->id,
                'quantity' => $data['quantity'],
                'price_paid' => $totalAmount,
                'additional_info' => [
                    'schedule_id' => $schedule->id,
                    'special_requests' => $data['special_requests'] ?? null,
                    'price_per_person' => $pricePerPerson,
                ],
            ]);

            // Update Schedule
            $schedule->decrement('available_slots', $data['quantity']);

            // Initiate Payment
            $payment = $this->paymentService->createPaymentIntentForBooking($booking);

            DB::commit();

            $booking->load(['details.bookable.images', 'details.bookable.schedules', 'user']);
            $booking->payment_client_secret = $payment->client_secret;
            $booking->payment_publishable_key = $payment->publishable_key;

            return $booking;

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'فشل حجز الجولة: ' . $e->getMessage(),
                'statusCode' => 500
            ];
        }
    }

    public function getUserBookings()
    {
        $user = Auth::user();

        return Booking::with(['details.bookable.images', 'details.bookable.schedules'])
            ->where('user_id', $user->id)
            ->whereHas('details', function ($q) {
                $q->where('bookable_type', Tour::class);
            })
            ->latest()
            ->paginate(10);
    }

    public function getBookingDetails($bookingId)
    {
        $user = Auth::user();

        return Booking::with(['details.bookable.images', 'details.bookable.schedules', 'user'])
            ->where('id', $bookingId)
            ->where('user_id', $user->id)
            ->whereHas('details', function ($q) {
                $q->where('bookable_type', Tour::class);
            })
            ->firstOrFail();
    }
}
