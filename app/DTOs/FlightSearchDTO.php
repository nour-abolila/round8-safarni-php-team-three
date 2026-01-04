<?php

namespace App\DTOs;

class FlightSearchDTO
{
    public function __construct(
        public readonly string $from,
        public readonly string $to,
        public readonly \DateTime $departureDate,
        public readonly ?\DateTime $returnDate,
        public readonly int $passengers,
        public readonly string $type,
    ) {}

    public function isOneWay(): bool
    {
        return $this->type === 'one-way';
    }

    public function isRoundTrip(): bool
    {
        return $this->type === 'round-trip';
    }
}
