<?php

namespace App\Resources\Flights;

use App\Resources\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'flight_number' => $this->flight_number,
            'departure_airport_code' => $this->departure_airport_code,
            'arrival_airport_code' => $this->arrival_airport_code,
            'scheduled_departure' => $this->scheduled_departure,
            'scheduled_arrival' => $this->scheduled_arrival,
            'duration_minutes' => $this->duration_minutes,
            'aircraft_type' => $this->aircraft_type,
            'booking_class' => $this->booking_class,
            'base_price' => $this->base_price,
            'total_price' => $this->total_price,
            'current_price' => $this->current_price,
            'total_seats' => $this->total_seats,
            'booked_seats' => $this->booked_seats,
            'available_seats' => $this->total_seats - $this->booked_seats,
            'category_name' => $this->category->key,
        ];
    }
}
