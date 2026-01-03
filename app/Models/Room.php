<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
     use HasFactory;
    protected $guarded = [];

   public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
