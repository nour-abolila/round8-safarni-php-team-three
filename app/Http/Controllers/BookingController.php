<?php

namespace App\Http\Controllers;

use App\DTOs\FlightSearchDTO;
use App\Helper\ApiResponse;
use App\Http\Requests\searchFlightRequest;
use App\Services\BookingServices\FlightServices;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct(protected FlightServices $flightServices)
    {}

    public function searchFlights(searchFlightRequest $request)
    {
        $searchDTO = new FlightSearchDTO(
            from: $request->from,
            to: $request->to,
            departureDate: new \DateTime($request->departure_date),
            returnDate: $request->has('return_date') ? new \DateTime($request->return_date) : null,
            passengers: $request->passengers,
            type: $request->type
        );

        $result = $this->flightServices->search($searchDTO);

        return ApiResponse::success(data: $result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'tour_schedule_id' => 'required|exists:tour_schedules,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string', // e.g., credit_card, paypal
        ]);

        $user = Auth::user();
        $tour = Tour::findOrFail($request->tour_id);
        $schedule = TourSchedule::where('id', $request->tour_schedule_id)
            ->where('tour_id', $request->tour_id)
            ->firstOrFail();

        if ($schedule->available_slots < $request->quantity) {
            return response()->json(['message' => 'Not enough available slots'], 400);
        }

        // Calculate price (mock logic as per previous assumption)
        $pricePerPerson = 150 * $tour->duration;
        $totalAmount = $pricePerPerson * $request->quantity;

        DB::beginTransaction();
        try {
            // Create Booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'booking_status' => 'confirmed',
                'total_amount' => $totalAmount,
                'payment_status' => 'paid', // Simulating immediate payment
            ]);

            // Create Booking Detail
            BookingDetail::create([
                'booking_id' => $booking->id,
                'bookable_type' => Tour::class,
                'bookable_id' => $tour->id,
                'quantity' => $request->quantity,
                'price_paid' => $totalAmount,
                'additional_info' => ['schedule_id' => $schedule->id],
            ]);

            // Create Payment
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalAmount,
                'status' => 'completed',
                'transaction_id' => Str::uuid(),
                'payment_method' => $request->payment_method,
            ]);

            // Update Schedule
            $schedule->decrement('available_slots', $request->quantity);

            DB::commit();

            return response()->json([
                'message' => 'Booking successful',
                'data' => $booking->load('details', 'user')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Booking failed', 'error' => $e->getMessage()], 500);
        }
    }
}
