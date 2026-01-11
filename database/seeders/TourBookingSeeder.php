<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\TourSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a user for bookings
        $user = User::firstOrCreate(
            ['email' => 'tour_user@example.com'],
            [
                'full_name' => 'Tour User',
                'password' => bcrypt('password'),
                'mobile' => '1234567890',
                'email_verified_at' => now(),
            ]
        );

        if (!$user->email_verified_at) {
            $user->update(['email_verified_at' => now()]);
        }

        // Get tours with schedules
        $tours = Tour::with('schedules')->get();

        if ($tours->isEmpty()) {
            $this->command->info('No tours found. Skipping TourBookingSeeder.');
            return;
        }

        foreach ($tours as $tour) {
            $schedule = $tour->schedules->first();

            // If no schedule exists, create one
            if (!$schedule) {
                $schedule = TourSchedule::create([
                    'tour_id' => $tour->id,
                    'start_date' => now()->addDays(15),
                    'capacity' => 20,
                    'available_slots' => 20,
                ]);
            }

            // Create a booking for this tour
            $quantity = rand(1, 3);
            $pricePerPerson = $tour->price ?? (150 * $tour->duration);
            $totalAmount = $pricePerPerson * $quantity;

            // Check if available slots enough
            if ($schedule->available_slots >= $quantity) {
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'booking_type' => 'tour',
                    'booking_status' => 'confirmed',
                    'total_amount' => $totalAmount,
                    'payment_status' => 'paid',
                ]);

                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'bookable_type' => Tour::class,
                    'bookable_id' => $tour->id,
                    'quantity' => $quantity,
                    'price_paid' => $totalAmount,
                    'additional_info' => [
                        'schedule_id' => $schedule->id,
                        'special_requests' => 'Vegetarian meal please.',
                        'price_per_person' => $pricePerPerson,
                    ],
                ]);

                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $totalAmount,
                    'status' => 'completed',
                    'transaction_id' => Str::uuid(),
                    'payment_method' => 'credit_card',
                ]);

                // Update available slots
                $schedule->decrement('available_slots', $quantity);
            }
        }
    }
}
