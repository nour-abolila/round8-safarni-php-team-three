<?php

namespace App\Models;
use App\Models\Hotel;
use App\Models\Car;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
<<<<<<< HEAD
      use HasFactory;
    protected $guarded = [];

    public function cars() {
        return $this->hasMany(Car::class);
    }
    public function hotels() {
        return $this->hasMany(Hotel::class);
    }
    public function flights() {
        return $this->hasMany(Flight::class);
    }
=======
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
>>>>>>> ac96d964345c7ee4a2177d0e80e2be57509c9e31
}
