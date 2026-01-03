<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
<<<<<<< HEAD
  use HasFactory;  
    public function imageable()
    {
        return $this->morphTo();
    }
=======
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'url',
    ];
>>>>>>> ac96d964345c7ee4a2177d0e80e2be57509c9e31

    // العلاقات
    public function imageable()
    {
        return $this->morphTo();
    }
}
