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
        $firstDetail = $this->details->first();

        return [
            'id' => $this->id,
            'payment_status' => $this->payment_status,
            'booking_status' => $this->booking_status,
            'total_amount' => $this->total_amount,
            'bookable_type' => optional($firstDetail)->bookable_type,
            'user_name' => $this->user->full_name,
            'user_email' => $this->user->email,
            'quantity' => optional($firstDetail)->quantity,
            'price_paid' => optional($firstDetail)->price_paid,
            'additional_info' => optional($firstDetail)->additional_info,
        ];
    }
}
