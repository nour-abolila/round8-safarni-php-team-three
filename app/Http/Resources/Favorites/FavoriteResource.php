<?php

namespace App\Http\Resources\Favorites;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        $tour = $this->favorable;
        return [
            'id' => optional($tour)->id,
            'title' => optional($tour)->title,
            'image' => optional($tour)->images->first()?->url,
            'duration' => optional($tour)->duration,
            'rating_average' => round(optional(optional($tour)->reviews)->avg('rating'), 1),
        ];
    }
}

