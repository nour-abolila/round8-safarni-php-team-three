<?php

namespace App\Models;
use App\Models\Hotel;
use App\Models\Car;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
}
