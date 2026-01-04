<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    public function toArray($request): array
    {
       return [
        
            'id' => $this->id,

            'name' => $this->name,
            
            'address' => $this->address,
            
            'location' => $this->location,
            
            'content_info' => $this->content_info,
            
            'rating' => $this->rating,
                        
            'image' => $this->images->first()?->url, 
        ];
    }
}
