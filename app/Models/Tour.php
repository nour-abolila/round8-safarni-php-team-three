<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'duration',
        'recommendation',
        'visit_season',
        'activities',
    ];

    protected $casts = [
        'activities' => 'array',
    ];

    // العلاقات
    public function schedules()
    {
        return $this->hasMany(TourSchedule::class);
    }

    public function bookingDetails()
    {
        return $this->morphMany(BookingDetail::class, 'bookable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
