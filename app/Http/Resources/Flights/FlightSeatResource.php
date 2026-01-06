<?php

namespace App\Http\Resources\Flights;

use Illuminate\Http\Resources\Json\JsonResource;

class FlightSeatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'seat_number' => $this->seat_number,
            'status' => $this->status,
            'is_who_booked' => $this->who_booked(auth()->user()->id)
        ];
    }
}
