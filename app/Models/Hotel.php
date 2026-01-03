<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
<<<<<<< HEAD
     use HasFactory;
    protected $guarded = [];

    public function rooms(){
        return $this->hasMany(Room::class);
    }
=======
    protected $fillable = [
        'name',
        'address',
        'location',
        'content_info',
        'description',
        'slug',
        'amenities',
        'category_id',
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    // العلاقات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookingDetails()
    {
        return $this->morphMany(BookingDetail::class, 'bookable');
    }

>>>>>>> ac96d964345c7ee4a2177d0e80e2be57509c9e31
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
<<<<<<< HEAD
     


=======

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
>>>>>>> ac96d964345c7ee4a2177d0e80e2be57509c9e31
}
