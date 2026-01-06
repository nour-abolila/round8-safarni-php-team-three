<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\Image;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{

     use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'amenities' => 'array',
    ];
    
    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function bookingDetails()
    {
        return $this->morphMany(BookingDetail::class, 'bookable');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

}
