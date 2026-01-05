<?php

namespace App\Repositories\BookingRepositories;

use App\Models\Flight;

class FlightRepositories
{

    public function findById(int $id): ?Flight
    {
        return Flight::findOrFail($id);
    }

    public function searchOneWay(array $criteria)
    {
        $query = Flight::query();

        $query->where('departure_date', $criteria['departure_date'])
              ->where('departure_airport_code', $criteria['from'])
              ->where('arrival_airport_code', $criteria['to'])
              ->whereRaw('(total_seats - booked_seats) >= ?', [$criteria['passengers']]);

        $query->orderBy('scheduled_departure');

        return ['flights' => $query->get()];

    }

    public function searchRoundTrip(array $criteria): array
    {
        $departureFlights = $this->searchOneWay([
            'from' => $criteria['from'],
            'to' => $criteria['to'],
            'departure_date' => $criteria['departure_date'],
            'passengers' => $criteria['passengers']
        ]);

        $returnFlights = $this->searchOneWay([
            'from' => $criteria['to'],
            'to' => $criteria['from'],
            'departure_date' => $criteria['return_date'],
            'passengers' => $criteria['passengers']
        ]);

        return [
            'departure_flights' => $departureFlights,
            'return_flights' => $returnFlights
        ];
    }

    public function findByFlightNumber(string $flightNumber): ?Flight
    {
        return Flight::where('flight_number', $flightNumber)->first();
    }

    public function getFlightSeat(Flight $flight, int $seatId)
    {
        return $flight->flightSeats()->where('id', $seatId)
        ->lockForUpdate()
        ->first();
    }

}
