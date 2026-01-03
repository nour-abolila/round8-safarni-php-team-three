<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    protected $fillable = [
        'tour_id',
        'start_date',
        'capacity',
        'available_slots',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    // العلاقات
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
