<?php

namespace App\Services\BookingServices;

use App\Helper\ApiResponse;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TourBookingService
{
    public function bookTour(array $data)
    {
        $user = Auth::user();
        $tour = Tour::findOrFail($data['tour_id']);
        $schedule = TourSchedule::where('id', $data['tour_schedule_id'])
            ->where('tour_id', $data['tour_id'])
            ->firstOrFail();

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
                'booking_type' => 'tour',
                'booking_status' => 'confirmed',
                'total_amount' => $totalAmount,
                'payment_status' => 'paid',
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

            // Create Payment
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalAmount,
                'status' => 'completed',
                'transaction_id' => Str::uuid(),
                'payment_method' => $data['payment_method'],
            ]);

            // Update Schedule
            $schedule->decrement('available_slots', $data['quantity']);

            DB::commit();

            return $booking->load(['details.bookable', 'user']);

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

        return Booking::with(['details.bookable', 'details.bookable.images'])
            ->where('user_id', $user->id)
            ->where('booking_type', 'tour')
            ->latest()
            ->paginate(10);
    }

    public function getBookingDetails($bookingId)
    {
        $user = Auth::user();

        return Booking::with(['details.bookable', 'details.bookable.images', 'user'])
            ->where('id', $bookingId)
            ->where('user_id', $user->id)
            ->where('booking_type', 'tour')
            ->firstOrFail();
    }
}
