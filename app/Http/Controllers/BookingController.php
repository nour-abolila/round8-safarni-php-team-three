<?php

namespace App\Http\Controllers;

use App\DTOs\FlightSearchDTO;
use App\Helper\ApiResponse;
use App\Http\Requests\searchFlightRequest;
use App\Http\Requests\SeatFlightRequest;
use App\Repositories\BookingRepositories\FlightRepositories;
use App\Http\Resources\Flights\FlightSeatResource;
use Illuminate\Http\Request;
use App\Services\BookingServices\FlightServices;

class BookingController extends Controller
{
    public function __construct(
        protected FlightServices $flightServices,
        protected FlightRepositories $flightRepositories
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
                'flight_seats' => FlightSeatResource::collection($flight->seats),
            ],
            message: 'تم جلب مقاعد الرحلة بنجاح'
        );
    }

    public function bookFlight($flightId, SeatFlightRequest $request)
    {
        return $this->flightServices->bookingFlight($flightId,$request->validated('seat_ids'));
    }

}
