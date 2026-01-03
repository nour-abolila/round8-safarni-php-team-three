<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
     use HasFactory;
    protected $guarded = [];

    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
     


}
