<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class BookingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'bookable_id',
        'bookable_type',
        'quantity',
        'price_paid',
        'additional_info',
    ];
    protected $guarded = [];

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
