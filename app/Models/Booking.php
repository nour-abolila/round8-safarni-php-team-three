<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\BookingDetail;
use App\Models\Payment;
class Booking extends Model
{

     use HasFactory;
    protected $fillable = [
      
        'user_id',
        'booking_type',
        'booking_status',
        'total_amount',
        'payment_status',

    ];
    protected $guarded = [];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
