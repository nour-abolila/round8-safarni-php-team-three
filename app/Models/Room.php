<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
<<<<<<< HEAD
     use HasFactory;
    protected $guarded = [];

   public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
=======
    protected $fillable = [
        'hotel_id',
        'name',
        'is_availability',
        'description',
        'area',
        'occupancy',
        'bed_number',
        'price_per_night',
        'refundable',
    ];

    protected $casts = [
        'is_availability' => 'boolean',
        'refundable' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    // العلاقات
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
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
>>>>>>> ac96d964345c7ee4a2177d0e80e2be57509c9e31
}
