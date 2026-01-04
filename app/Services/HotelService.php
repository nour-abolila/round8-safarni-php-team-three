<?php

namespace App\Services;
use App\Models\Hotel;

class HotelService {
    
    public function getHotels(?float $lat = null , ?float $lan = null){
            
           $query = Hotel::query()->with('images')
           
           ->orderByDesc('rating');

            
        if ($lat && $lng) {
            
            $query->selectRaw("
            
                hotels.*,
            
                ( 6371 * acos(
              
                cos(radians(?)) *
              
                cos(radians(lat)) *
              
                cos(radians(lng) - radians(?)) +
              
                sin(radians(?)) *
              
                sin(radians(lat))
              
                )) AS distance
            
                ", [$lat, $lng, $lat])
            
                ->orderBy('distance');
        }

        return $query->paginate(10);
     }
    public function getHotelDetails(int $id){

        return Hotel::with([
           
            'images',

             'rooms' => function ($q) {
            
                $q->where('is_available', true);
           
            }])->findOrFail($id);

     }
}
