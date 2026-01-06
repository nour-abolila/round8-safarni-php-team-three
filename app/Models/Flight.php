<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number',
        'departure_airport_code',
        'arrival_airport_code',
        'scheduled_departure',
        'scheduled_arrival',
        'departure_date',
        'arrival_date',
        'duration_minutes',
        'aircraft_type',
        'booking_class',
        'base_price',
        'total_price',
        'booked_seats',
        'total_seats',
        'current_price',
        'price_last_updated',
        'category_id',
    ];

    protected $casts = [
        'scheduled_departure' => 'datetime',
        'scheduled_arrival' => 'datetime',
        'price_last_updated' => 'datetime',
        'base_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'current_price' => 'decimal:2',
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

    public function flightSeats()
    {
        return $this->hasMany(FlightSeat::class);
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
