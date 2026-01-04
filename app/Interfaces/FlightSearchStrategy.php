<?php

namespace App\Interfaces\FlightSearch;

use App\Interfaces\Repositories\FlightRepositoryInterface;

interface FlightSearchStrategy
{
    public function search(array $criteria);
}
