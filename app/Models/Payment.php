<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Payment extends Model
{
    use HasFactory;
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
