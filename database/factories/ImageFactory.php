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

       
        $id = $type::count() ? $type::inRandomOrder()->first()->id : null;

        if (!$id) {
            return []; 
        }

       
  
       
            $hotelImages = [
                'https://picsum.photos/id/1015/640/480',
                'https://picsum.photos/id/1016/640/480',
                'https://picsum.photos/id/1020/640/480',
                'https://picsum.photos/id/1024/640/480',
                'https://picsum.photos/id/1027/640/480',
            ];

    
            $roomImages = [
                'https://picsum.photos/id/1035/640/480',
                'https://picsum.photos/id/1036/640/480',
                'https://picsum.photos/id/1040/640/480',
                'https://picsum.photos/id/1044/640/480',
                'https://picsum.photos/id/1047/640/480',
            ];


        $url = $type === Hotel::class
            ? $this->faker->randomElement($hotelImages)
            : $this->faker->randomElement($roomImages);

        return [
            'url' => $url,
            'imageable_id' => $id,
            'imageable_type' => $type,
        ];
    }
}
