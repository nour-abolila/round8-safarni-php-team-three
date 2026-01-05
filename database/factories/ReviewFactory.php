<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Hotel;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        $users = User::pluck('id')->all();

        $hotels = Hotel::pluck('id')->all();

        return [

            'user_id' => $this->faker->randomElement($users),

            'reviewable_id' => $this->faker->randomElement($hotels),

            'reviewable_type' => 'App\Models\Hotel',

            'rating' => $this->faker->numberBetween(1, 5),

            'status' => $this->faker->randomElement(['approved', 'pending']),
        
        ];
    }
}
