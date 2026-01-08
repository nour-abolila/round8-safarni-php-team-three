<?php

namespace App\Http\Resources\Bookings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return
        [
            'id' => $this->id,
            'bookable_type' => optional($this->details->first())->bookable_type,
            'booking_status' => $this->booking_status,
            'total_amount' => $this->total_amount
        ];
    }
}
