<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
          
            'id'  => $this->id,
          
            'hotel_id'  => $this->reviewable_id,
          
            'rating'    => $this->rating,
          
            'status'    => $this->status,

             'comment'   => $this->comment,
          
            'user'      => [
          
                'id'   => $this->user->id,
          
                'name' => $this->user->name,
          
            ],
          
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}


