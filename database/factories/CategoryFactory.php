<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $names = ['Flights', 'Tours', 'Cars', 'Hotels'];
        $name = $this->faker->unique()->randomElement($names);

        return [
            'title' => $name,
            'key' => strtolower($name), 
        ];
    }
}
