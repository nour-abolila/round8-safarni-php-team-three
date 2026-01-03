<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition()
    {
        $name = $this->faker->company;
        return [
           
            'name' => $name,
           
            'address' => $this->faker->address,
           
            'location' => $this->faker->city,
           
            'lat' => $this->faker->latitude,
           
            'lng' => $this->faker->longitude,
           
            'rating' => $this->faker->randomFloat(1, 1, 5),
           
            'content_info' => $this->faker->sentence,
           
            'description' => $this->faker->paragraph,
           
            'slug' => Str::slug($name) . '-' . Str::random(5),
           
            'category_id' => rand(1,4),
        ];
    }
}
