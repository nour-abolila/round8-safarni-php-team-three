<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    public function schedules() {
    return $this->hasMany(TourSchedule::class);
}

}
