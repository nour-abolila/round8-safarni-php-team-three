<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        $paymentStatuses = ['unpaid', 'paid', 'refunded'];

        $types = ['hotel', 'flight', 'car', 'tour'];

        return [

            'user_id' => User::inRandomOrder()->first()->id ?? 1,

            'booking_type' => $this->faker->randomElement($types),

            'booking_status' => $this->faker->randomElement($statuses),

            'total_amount' => 0, 

            'payment_status' => $this->faker->randomElement($paymentStatuses),

            'confirmed_at' => now()->subDays(rand(0,10)),
        ];
    }
}
