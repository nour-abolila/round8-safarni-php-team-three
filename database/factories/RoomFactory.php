<?php
namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
           
            'hotel_id' => Hotel::inRandomOrder()->first()->id ?? 1,
           
            'name' => $this->faker->word . ' Room',
           
            'is_available' => $this->faker->boolean,
           
            'description' => $this->faker->sentence,
           
            'area' => $this->faker->numberBetween(20, 100),
           
            'occupancy' => $this->faker->numberBetween(1, 4),
           
            'bed_number' => $this->faker->numberBetween(1, 3),
           
            'price_per_night' => $this->faker->randomFloat(2, 50, 500),
           
            'refundable' => $this->faker->boolean,
        ];
    }
}
