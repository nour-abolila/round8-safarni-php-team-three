<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
          
            'id' => $this->id,
          
            'name' => $this->name,
          
            'description' => $this->description,
          
            'area' => $this->area,
          
            'occupancy' => $this->occupancy,
          
            'bed_number' => $this->bed_number,
          
            'price_per_night' => $this->price_per_night,
          
            'refundable' => $this->refundable,
          
            'hotel' => [
          
                'hotel_id' => $this->hotel->id,
          
                'name' => $this->hotel->name,
          
                'location' => $this->hotel->location,
            ],
          
            'images' => $this->images->map(fn($img) => $img->url),
        ];
    }
}
