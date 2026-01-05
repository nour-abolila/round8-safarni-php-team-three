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

    protected $casts = [
        'is_availability' => 'boolean',
        'refundable' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];
   
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function bookingDetails()
    {
        return $this->morphMany(BookingDetail::class, 'bookable');
    }
     public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
