<?php

namespace App\Http\Controllers;

use App\DTOs\FlightSearchDTO;
use App\Helper\ApiResponse;
use App\Http\Requests\Car\bookingCarRequest;
use App\Http\Requests\searchFlightRequest;
use App\Http\Requests\SeatFlightRequest;
use App\Http\Resources\Bookings\BookingResource;
use App\Repositories\BookingRepositories\BookRepository;
use App\Repositories\BookingRepositories\FlightRepositories;
use App\Http\Resources\Flights\FlightSeatResource;
use App\Services\BookingServices\Cars\CarService;
use App\Services\BookingServices\FlightServices;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct(
        protected FlightServices $flightServices,
        protected FlightRepositories $flightRepositories,
        protected CarService $carServices,
        protected BookRepository $bookRepository
        )
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

        return $this->flightServices->formatSearchResult($result, $searchDTO->type);
    }

    public function getFlightSeat($id)
    {
        $flight = $this->flightRepositories->findById($id);

        return ApiResponse::success(
            data: [
                'flight_seats' => FlightSeatResource::collection($flight->flightSeats),
            ],
            message: 'تم جلب مقاعد الرحلة بنجاح'
        );
    }

    public function bookFlight($flightId, SeatFlightRequest $request)
    {
        return $this->flightServices->bookingFlight($flightId,$request->validated('seat_ids'));
    }

    public function bookCar(bookingCarRequest $request)
    {
        return $this->carServices->bookCar($request->validated());
    }

    public function searchCar(Request $request)
    {
        $search = $request->input('search');
        return $this->carServices->searchCars($search);
    }

    public function getUserBookings(Request $request)
    {
        $request->validate([
            'type' =>'required|string|in:Car,Flight,Room,Tour'
        ]);

        $bookings = $this->bookRepository->getUserBookings($request->type);
        return ApiResponse::success(
            data: BookingResource::collection($bookings),
            message: 'User Bookings are :'
        );
    }
}
