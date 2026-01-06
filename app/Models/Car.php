<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'model_year',
        'vehicle_class',
        'seat_count',
        'door_count',
        'fuel_type',
        'power',
        'max_speed',
        'acceleration',
        'transmission',
        'luggage_capacity',
        'has_ac',
        'current_location_lat',
        'current_location_lng',
        'price',
        'location',
        'features',
        'is_available',
        'category_id',
    ];

    protected $casts = [
        'features' => 'array',
        'has_ac' => 'boolean',
        'is_available' => 'boolean',
    ];

    // العلاقات
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
}
