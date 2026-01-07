<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    public function toArray($request): array
    {
       return [
        
            'id' => $this->id,

            'name' => $this->name,
             
            'location' => $this->location,
            
            'content_info' => $this->content_info,
            
            'rating' => round($this->reviews_avg_rating, 1),
            
            'image' => $this->images->first()?->url, 
        ];
    }
}
