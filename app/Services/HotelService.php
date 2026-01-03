<?php

namespace App\Services;
use App\Models\Hotel;
class HotelService
{
    /**
     * Create a new class instance.
     */
        public function getHotels(){
            Hotel::with('images')->orderByDesc('rating')->get();
        }
}
