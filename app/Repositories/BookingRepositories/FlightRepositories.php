<?php

namespace App\Repositories\BookingRepositories;

use App\Interfaces\Repositories\FlightRepositoryInterface;
use App\Models\Flight;
use App\Resources\Flights\FlightResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FlightRepositories
{
    public function searchOneWay(array $criteria): array
    {
        $query = Flight::query();

        $query->where('departure_date', $criteria['departure_date'])
              ->where('departure_airport_code', $criteria['from'])
              ->where('arrival_airport_code', $criteria['to'])
              ->whereRaw('(total_seats - booked_seats) >= ?', [$criteria['passengers']]);

        $query->orderBy('scheduled_departure');

        return [
            'flights' => FlightResource::collection($query->get())
        ];
    }

    public function searchRoundTrip(array $criteria): array
    {
        $departureFlights = $this->searchOneWay([
            'from' => $criteria['from'],
            'to' => $criteria['to'],
            'departure_date' => $criteria['departure_date']
        ]);

        $returnFlights = $this->searchOneWay([
            'from' => $criteria['to'],
            'to' => $criteria['from'],
            'departure_date' => $criteria['return_date']
        ]);

        return [
            'departure_flights' => FlightResource::collection($departureFlights),
            'return_flights' => FlightResource::collection($returnFlights)
        ];
    }

    public function findByFlightNumber(string $flightNumber): ?Flight
    {
        return Flight::where('flight_number', $flightNumber)->first();
    }

     public function checkSeatAvailability(int $flightId, int $requiredSeats): bool
    {
        $flight = Flight::find($flightId);
        if (!$flight) {
            return false;
        }

        $availableSeats = $flight->total_seats - $flight->booked_seats;
        return $availableSeats >= $requiredSeats;
    }
}
