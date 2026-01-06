<?php

namespace App\Services\Hotel;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Review;
use App\Models\Hotel;
use Illuminate\Validation\ValidationException;
class HotelReviewService
{

    public function create(int $userId, array $data): Review
    {

        $hotelId = $data['hotel_id'];

        $hasStayed = Booking::where('user_id', $userId)

        ->where('booking_type', 'hotel')

        ->where('booking_status', 'completed')

        ->whereHas('bookingDetails', function ($q) use ($hotelId) {

            $q->whereHasMorph(

                'bookable',

                [Room::class],

                fn ($room) => $room->where('hotel_id', $hotelId)

            );
            })

            ->exists();

        if (! $hasStayed) {

            throw ValidationException::withMessages([

                'review' => 'You must stay at the hotel before reviewing it.'
]);


        }

        return Review::create([

            'user_id'          => $userId,

            'reviewable_id'    => $hotelId,

            'reviewable_type'  => Hotel::class,

            'rating'           => $data['rating'],

            'status'           => 'pending',
        ]);
    }

    public function listHotelReviews(int $hotelId)
    {
        return Review::where('reviewable_type', Hotel::class)
     
        ->where('reviewable_id', $hotelId)
     
        ->orderByDesc('created_at')
     
        ->get();
    }

}



