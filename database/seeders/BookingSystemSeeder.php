<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;

class BookingSystemSeeder extends Seeder
{
    public function run(): void
    {
        Booking::factory(10)->create()->each(function($booking) {
        
            $details = BookingDetail::factory(rand(1,2))->create([
        
                'booking_id' => $booking->id
            ]);

           
            $booking->update([
           
                'total_amount' => $details->sum('price_paid')
            ]);

            Payment::factory(rand(1,2))->create([

                'booking_id' => $booking->id
            ]);
        });
    }
}
