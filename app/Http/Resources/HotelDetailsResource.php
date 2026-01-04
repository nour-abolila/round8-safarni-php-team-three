<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
 public function toArray($request)
    {
        return [
           
            'id' => $this->id,
           
            'name' => $this->name,
           
            'address' => $this->address,
           
            'location' => $this->location,
           
            'image' => $this->images->first()?->url,
           
            'lat' => $this->lat,
           
            'lng' => $this->lng,
           
            'rating' => $this->rating,
           
            'content_info' => $this->content_info,
           
            'description' => $this->description,
           
            'amenities' => $this->amenities,
           
            'rooms' => $this->rooms->map(function ($room) {
           
                return [
           
                    'id' => $room->id,
           
                    'name' => $room->name,
                ];
            }),
        ];
    }
}

