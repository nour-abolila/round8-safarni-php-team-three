<?php

namespace App\Interfaces\Repositories;

interface FlightRepositoryInterface
{
    public function searchOneWay(array $criteria);
    public function searchRoundTrip(array $criteria);
    public function findByFlightNumber(string $flightNumber);
}
