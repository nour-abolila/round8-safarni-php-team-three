<?php

namespace App\Services;
use App\Models\Room;
class RoomService
{
       public function getRoomDetails($id)
    {
           return Room::where('id', $id)
        
           ->where('is_available', true)
        
           ->with(['hotel', 'images'])
        
           ->first();
    }
}