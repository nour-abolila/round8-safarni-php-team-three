<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelBookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
           
            'id'  => $this->id,
           
            'booking_type'   => $this->booking_type,
           
            'booking_status' => $this->booking_status,
           
            'payment_status' => $this->payment_status,
           
            'total_amount'   => $this->total_amount,
           
            'rooms' => $this->bookingDetails->map(function($detail) {
           
                return [
           
                    'room_id'   => $detail->bookable_id,
           
                     'hotel_id'  => $detail->bookable->hotel_id,

                    'adults'    => $detail->additional_info['adults'],
           
                    'teens'     => $detail->additional_info['teens'],
           
                    'children'  => $detail->additional_info['children'],
           
                    'check_in'  => $detail->additional_info['check_in'],
           
                    'check_out' => $detail->additional_info['check_out'],
           
                    'nights'    => $detail->additional_info['nights'], 
           
                    'price_paid'=> $detail->price_paid,
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
