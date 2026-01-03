<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           Category::factory()->count(4)->create();
        $categories = [
            [
                'key' => 'flights_economy',
                'title' => 'رحلات اقتصادية'
            ],
            [
                'key' => 'flights_business',
                'title' => 'رحلات رجال الأعمال'
            ],
            [
                'key' => 'cars_economy',
                'title' => 'سيارات اقتصادية'
            ],
            [
                'key' => 'cars_suv',
                'title' => 'سيارات دفع رباعي'
            ],
            [
                'key' => 'cars_luxury',
                'title' => 'سيارات فاخرة'
            ],
        ];

        DB::table('categories')->insert($categories);

    }
}
