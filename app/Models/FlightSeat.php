<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightSeat extends Model
{
    protected $fillable = [
        'flight_id',
        'seat_number',
        'status',
        'lock_expiry',
    ];

    protected $casts = [
        'lock_expiry' => 'datetime',
    ];

    // العلاقات
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
