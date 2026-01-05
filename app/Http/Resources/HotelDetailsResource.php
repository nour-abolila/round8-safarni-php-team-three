<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            
            'id' => $this->id,
            
            'name' => $this->name,
            
            'location' => $this->location,
            
            'image' => $this->images->first()?->url,
            
            'lat' => $this->lat,
            
            'lng' => $this->lng,
            
            'rating' => $this->reviews_avg_rating, 
            
            'content_info' => $this->content_info,
            
            'description' => $this->description,
            
            'amenities' => $this->amenities,

          
            'rooms' => $this->rooms ? [
          
                'data' => collect($this->rooms->items())->map(function ($room) {
          
                    return [
          
                        'id' => $room->id,
          
                        'name' => $room->name,
                    ];
                }),
          
                'current_page' => $this->rooms->currentPage(),
          
                'last_page' => $this->rooms->lastPage(),
          
                'per_page' => $this->rooms->perPage(),
          
                'total' => $this->rooms->total(),
            ] : [],
        ];
    }
}
