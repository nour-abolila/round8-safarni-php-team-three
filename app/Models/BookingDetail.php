<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'bookable_id',
        'bookable_type',
        'quantity',
        'price_paid',
        'additional_info',
    ];

    protected $casts = [
        'additional_info' => 'array',
        'price_paid' => 'decimal:2',
    ];

    // العلاقات
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function bookable()
    {
        return $this->morphTo();
    }
}
