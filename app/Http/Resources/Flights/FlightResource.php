<?php

namespace App\Http\Resources\Flights;

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
            'departure_date' => $this->scheduled_departure->format('Y-m-d'),
            'arrival_date' => $this->scheduled_arrival->format('Y-m-d'),
            'departure_time' => $this->scheduled_departure->format('H:i'),
            'arrival_time' => $this->scheduled_arrival->format('H:i'),
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
