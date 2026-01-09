<?php

namespace App\Services\Hotel;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class HotelBookingService
{
    public function book(int $userId, array $data): Booking
    {
        $room = Room::findOrFail($data['room_id']);

        $checkIn  = Carbon::parse($data['check_in']);
      
        $checkOut = Carbon::parse($data['check_out']);
      
        $nights   = $checkIn->diffInDays($checkOut);

        $totalAmount = $room->price_per_night * $nights;
        
    $userExistingBooking = Booking::where('user_id', $userId)
   
    ->where('booking_status', 'pending')
   
    ->whereHas('bookingDetails', function($q) use ($room) {
   
        $q->where('bookable_id', $room->id)
   
        ->where('bookable_type', Room::class);
   
    })
   
    ->first();

    if ($userExistingBooking) {
   
        throw ValidationException::withMessages([
   
            'room' => ['You have already booked this room.']
        ]);
    }

    $conflictBooking = BookingDetail::where('bookable_id', $room->id)

    ->where('bookable_type', Room::class)

    ->whereHas('booking', function($q) {

        $q->where('booking_status', 'pending');

    })

    ->exists();

    if ($conflictBooking) {

        throw ValidationException::withMessages([

            'room' => ['This room is not available']
        ]);
    }

        $booking = Booking::create([
      
            'user_id'        => $userId,
      
            'booking_status' => 'pending',
      
            'payment_status' => 'unpaid',
            
            'total_amount'   => $totalAmount,
        ]);

        
        BookingDetail::create([
            
            'booking_id'     => $booking->id,
            
            'bookable_id'    => $room->id,
            
            'bookable_type'  => Room::class,
            
            'quantity'       => 1,
            
            'price_paid'     => $totalAmount,
            
            
            'additional_info'=> [
                
                'check_in'  => $data['check_in'],
                
                'check_out' => $data['check_out'],
                
                'adults'    => $data['adults'],
                
                'teens'     => $data['teens'] ?? 0,
                
                'children'  => $data['children'] ?? 0,
                
                'nights' => $nights,
            ],
        ]);

        return $booking->load('bookingDetails');
    }

  
    public function listUserBookings(int $userId, int $perPage = 10)
    {
        $bookings = Booking::with('bookingDetails')
      
        ->where('user_id', $userId)
      
         ->whereHas('bookingDetails')

        ->orderByDesc('created_at')
      
        ->paginate($perPage);

        return $bookings;
    }
}
