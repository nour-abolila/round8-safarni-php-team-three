<?php

namespace App\Interfaces\Services;

use App\DTOs\FlightSearchDTO;

interface FlightSearchServiceInterface
{
    public function search(FlightSearchDTO $searchDTO);
}
