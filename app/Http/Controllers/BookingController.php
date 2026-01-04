<?php

namespace App\Http\Controllers;

use App\DTOs\FlightSearchDTO;
use App\Helper\ApiResponse;
use App\Http\Requests\searchFlightRequest;
use Illuminate\Http\Request;
use App\Services\BookingServices\FlightServices;

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


}
