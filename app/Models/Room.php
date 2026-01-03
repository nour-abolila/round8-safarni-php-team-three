<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'hotel_id',
        'name',
        'is_availability',
        'description',
        'area',
        'occupancy',
        'bed_number',
        'price_per_night',
        'refundable',
    ];

    protected $casts = [
        'is_availability' => 'boolean',
        'refundable' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    // العلاقات
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
