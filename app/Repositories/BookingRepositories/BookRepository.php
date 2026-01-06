<?php

namespace App\Repositories\BookingRepositories;

use App\Models\Booking;
use App\Models\BookingDetail;

class BookRepository
{
    public function createBooking(array $data): Booking
    {
        return Booking::create($data);
    }

    public function updateBooking(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking;
    }

    public function createDetails(array $data)
    {
        return BookingDetail::create($data);
    }

    public function find($id)
    {
        return Booking::findOrFail($id);
    }
}
