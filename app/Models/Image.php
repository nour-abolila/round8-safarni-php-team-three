<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function images() {
    return $this->morphMany(Image::class, 'imageable');
}

}
