<?php

namespace App\Services\BookingServices;

use App\Factories\FlightSearchStrategyFactory;
use App\Interfaces\Repositories\FlightRepositoryInterface;
use App\Interfaces\Services\FlightSearchServiceInterface;
use App\Models\Flight;
use App\Repositories\BookingRepositories\FlightRepositories;
use Illuminate\Database\Eloquent\Collection;
use App\DTOs\FlightSearchDTO;

class FlightServices implements FlightSearchServiceInterface
{
public function __construct(
        protected FlightRepositoryInterface $flightRepository,
        protected FlightRepositories $flightRepositories
    ) {}

    public function search(FlightSearchDTO $searchDTO): array
    {


        $criteria = [
            'from' => $searchDTO->from,
            'to' => $searchDTO->to,
            'departure_date' => $searchDTO->departureDate,
            'return_date' => $searchDTO->returnDate ?? null,
            'passengers' => $searchDTO->passengers
        ];

        $strategy = FlightSearchStrategyFactory::create(
            $searchDTO->type,
            ['flightRepository' => $this->flightRepository]
        );

        if ($searchDTO->type === 'round-trip') {
            return $this->flightRepositories->searchRoundTrip($criteria);
        } else {
            return $this->flightRepositories->searchOneWay($criteria);
        }

        // return $strategy->search($criteria);
    }
}
