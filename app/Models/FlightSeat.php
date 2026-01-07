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
        'user_id'
    ];

    protected $casts = [
        'lock_expiry' => 'datetime',
    ];

    // العلاقات
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function who_booked($id)
    {
        return $this->user_id == $id && $this->status == 'booked';
    }
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isLocked(): bool
    {
        // return $this->status === 'locked' && $this->lock_expiry && $this->lock_expiry > now();
        $key = "seat".$this->id;
        return cache()->has($key);
    }

    public function isBooked(): bool
    {
        return $this->status === 'booked';
    }

    public function lock(int $minutes = 5): bool
    {
        // return $this->update([
        //     'status' => 'locked',
        //     'lock_expiry' => now()->addMinutes($minutes)
        // ]);
        $key = "seat".$this->id;
        cache()->put($key, $this->id, now()->addMinutes($minutes));
        return true;
    }

    public function unlock(): bool
    {
        // return $this->update([
        //     'status' => 'available',
        //     'lock_expiry' => null
        // ]);
        $key = "seat".$this->id;
        cache()->forget($key);
        return true;
    }
}
