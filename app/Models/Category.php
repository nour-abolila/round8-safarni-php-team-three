<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
