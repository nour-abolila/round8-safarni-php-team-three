<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'key',
        'title',
    ];

    // العلاقات
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
