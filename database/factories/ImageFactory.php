<?php
namespace Database\Factories;

use App\Models\Image;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        $types = ['App\Models\Hotel', 'App\Models\Room'];
       
        $type = $this->faker->randomElement($types);

        $id = $type::inRandomOrder()->first()->id ?? 1;

        return [
            
            'url' => 'https://picsum.photos/640/480?random=' . $this->faker->unique()->numberBetween(1, 1000),

            'imageable_id' => $id,
            
            'imageable_type' => $type,
        ];
    }
}
