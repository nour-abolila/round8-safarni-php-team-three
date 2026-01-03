<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'address',
        'location',
        'content_info',
        'description',
        'slug',
        'amenities',
        'category_id',
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    // العلاقات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
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
