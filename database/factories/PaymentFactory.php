<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        $methods = ['card', 'paypal', 'cash'];

        $statuses = ['pending', 'paid', 'refunded'];

        $providers = ['stripe', 'paymob', 'paypal'];

        $booking = Booking::inRandomOrder()->first();

        $amount = $booking ? $booking->bookingDetails()->sum('price_paid') : $this->faker->numberBetween(50, 500);

        return [

            'booking_id' => $booking?->id ?? 1,

            'amount' => $amount,

            'status' => $this->faker->randomElement($statuses),

            'transaction_id' => $this->faker->uuid(),

            'payment_method' => $this->faker->randomElement($methods),

            'provider' => $this->faker->randomElement($providers),
        ];
    }
}
