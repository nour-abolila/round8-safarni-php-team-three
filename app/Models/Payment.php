<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'status',
        'transaction_id',
        'payment_method',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // العلاقات
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
