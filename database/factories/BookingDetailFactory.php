<?php

namespace Database\Factories;

use App\Models\BookingDetail;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingDetailFactory extends Factory
{
    protected $model = BookingDetail::class;

    public function definition()
    {
        $types = ['App\Models\Hotel', 'App\Models\Room'];
      
        $type = $this->faker->randomElement($types);
      
        $id = $type::inRandomOrder()->first()->id ?? 1;

        $adults = $this->faker->numberBetween(1, 3);
      
        $teens = $this->faker->numberBetween(0, 2);
      
        $children = $this->faker->numberBetween(0, 2);

        $check_in = $this->faker->dateTimeBetween('+1 days', '+30 days');
      
        $check_out = (clone $check_in)->modify('+'.rand(1,10).' days');

        $price = $this->faker->numberBetween(50, 500);

        return [
      
            'booking_id' => Booking::inRandomOrder()->first()->id ?? 1,
      
            'bookable_id' => $id,
      
            'bookable_type' => $type,
      
            'quantity' => 1,
      
            'price_paid' => $price,
      
            'additional_info' => [
      
                'adults' => $adults,
      
                'teens' => $teens,
      
                'children' => $children,
      
                'check_in' => $check_in->format('Y-m-d'),
      
                'check_out' => $check_out->format('Y-m-d'),
            ],
        ];
    }
}
