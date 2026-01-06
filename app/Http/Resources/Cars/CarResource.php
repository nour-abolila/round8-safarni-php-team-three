<?php

namespace App\Http\Resources\Cars;

use App\Http\Resources\Images\ImageResource;
use App\Http\Resources\Categories\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'model_year' => $this->model_year,
            'vehicle_class' => $this->vehicle_class,
            'seat_count' => $this->seat_count,
            'door_count' => $this->door_count,
            'fuel_type' => $this->fuel_type,
            'transmission' => $this->transmission,
            'luggage_capacity' => $this->luggage_capacity,
            'has_ac' => $this->has_ac,
            'current_location_lat' => $this->current_location_lat,
            'current_location_lng' => $this->current_location_lng,
            'location' => $this->location,
            'features' => $this->features,
            'is_available' => $this->is_available,
            'category' => $this->category->key,
            'images' => ImageResource::collection($this->images),

        ];
    }
}
