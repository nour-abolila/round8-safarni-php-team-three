<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    protected $guarded = [];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
