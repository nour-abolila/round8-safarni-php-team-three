<?php

namespace App\Services\BookingServices;

use App\Helper\ApiResponse;
use App\Http\Resources\Bookings\BookingResource;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\Flight;
use App\Repositories\BookingRepositories\BookRepository;
use App\Repositories\BookingRepositories\FlightRepositories;
use App\DTOs\FlightSearchDTO;
use App\Http\Resources\Flights\FlightResource;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class FlightServices
{
public function __construct(
        protected FlightRepositories $flightRepositories,
        protected BookRepository $bookRepository,
    ) {}

    public function search(FlightSearchDTO $searchDTO): Collection|array
    {
        $airpotr_form = Airport::where('city', $searchDTO->from)->firstOrFail();

        if (!$airpotr_form) {
            throw new Exception('Flights not found from ' . $searchDTO->from);
        }
        $airpotr_to = Airport::where('city', $searchDTO->to)->firstOrFail();

        if (!$airpotr_to) {
            throw new Exception('Flights not found to ' . $searchDTO->to);
        }

        $criteria = [
            'from' => $airpotr_form->airport_code,
            'to' => $airpotr_to->airport_code,
            'departure_date' => $searchDTO->departureDate,
            'return_date' => $searchDTO->returnDate ?? null,
            'passengers' => $searchDTO->passengers
        ];

        if ($searchDTO->type === 'round-trip') {
            return $this->flightRepositories->searchRoundTrip($criteria);
        } else {
            return $this->flightRepositories->searchOneWay($criteria);
        }
    }
    public function formatSearchResult(array $result, string $type)
    {
        if ($type === 'one-way') {
            $flights = $this->extractFlights($result);

            return ApiResponse::success(
                data: [
                    'type' => 'one-way',
                    'flights' => FlightResource::collection($flights),
                    'total_results' => $flights->count(),
                ],
                message: 'تم العثور على رحلات الذهاب بنجاح'
            );
        } else {
            $departureFlights = $this->extractFlights($result['departure_flights'] ?? []);
            $returnFlights = $this->extractFlights($result['return_flights'] ?? []);

            return ApiResponse::success(
                data: [
                    'type' => 'round-trip',
                    'departure_flights' => FlightResource::collection($departureFlights),
                    'return_flights' => FlightResource::collection($returnFlights),
                    'total_departure_results' => $departureFlights->count(),
                    'total_return_results' => $returnFlights->count(),
                    'combinations_count' => $departureFlights->count() * $returnFlights->count(),
                ],
                message: 'تم العثور على رحلات الذهاب والعودة بنجاح'
            );
        }
    }

    private function extractFlights($data): Collection
    {
        if ($data instanceof Collection) {
            return $data;
        }

        if (is_array($data)) {
            if (isset($data['flights']) && $data['flights'] instanceof Collection) {
                return $data['flights'];
            }

            if (isset($data['flights']) && is_array($data['flights'])) {
                return collect($data['flights']);
            }

            return collect($data);
        }

        return collect();
    }

    public function bookingFlight($flightId, array $seatId)
    {
        try {
        return DB::transaction(function () use ($flightId, $seatId) {
            return $this->processBooking($flightId, $seatId);
        });
        } catch (Exception $e) {
            return ApiResponse::error(message:
            'حدث خطأ أثناء عملية الحجز. يرجى المحاولة مرة أخرى.'
            .$e->getMessage()
        );
        }
    }
    private function processBooking($flightId, array $seatId)
    {
       $flight = $this->flightRepositories->findById($flightId);

       $totalPassengers = 0;

       foreach ($seatId as $seat_id) {

        $totalPassengers += 1;

        $seat = $this->flightRepositories->getFlightSeat($flight, $seat_id);


        if (!$seat) {
            return new Exception("المقعد الذي تحاول حجزه غير موجود");
        }

        if (!$seat->isAvailable()) {
            return new Exception("المقعد {$seat->seat_number} غير متاح");
        }
        if ($seat->isLocked()) {
            return new Exception("المقعد {$seat->seat_number} مقفل مؤقتًا. يرجى المحاولة لاحقًا.");
        }

        $seat->lock();

        $seat->update([
            'status' => 'booked',
            'user_id' => auth()->user()->id
        ]);

       }


        $booking = $this->createBooking([
            'total_amount' => $flight->current_price * $totalPassengers,
        ]);

        $bookingDetails = $this->createBookingDetails($flight, $booking, [
            'total_passengers' => $totalPassengers,
            ], $seatId);

        return ApiResponse::success(
            data: ['booking' => new BookingResource($booking)],
            message: 'تم حجز المقعد بنجاح'
        );
    }

    private function createBooking(array $data)
    {
        return $this->bookRepository->createBooking([
            'user_id' => auth()->user()->id,
            'booking_status' => 'pending',
            'total_amount' => $data['total_amount'],
            'payment_status' => 'pending',
        ]);
    }

    private function createBookingDetails(Flight $flight, Booking $booking, array $data, array $seatIds)
    {
        return $this->bookRepository->createDetails([
            'booking_id' => $booking->id,
            'bookable_id' => $flight->id,
            'bookable_type' => get_class($flight),
            'quantity' => $data['total_passengers'],
            'price_paid' => $flight->current_price,
            'additional_info' => ['seats' => $seatIds],
        ]);
    }
}
