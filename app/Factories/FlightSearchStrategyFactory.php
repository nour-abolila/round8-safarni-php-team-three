<?php

namespace App\Factories;

use App\Interfaces\FlightSearch\FlightSearchStrategy;
use App\Strategies\FlightSearch\OneWaySearchStrategy;
use App\Strategies\FlightSearch\RoundTripSearchStrategy;
use InvalidArgumentException;

class FlightSearchStrategyFactory
{
    public static function create(string $type, $dependencies): FlightSearchStrategy
    {
        return match($type) {
            'one-way' => new OneWaySearchStrategy($dependencies['flightRepository']),
            'round-trip' => new RoundTripSearchStrategy($dependencies['flightRepository']),
            default => throw new InvalidArgumentException("Invalid flight type: {$type}")
        };
    }
}
