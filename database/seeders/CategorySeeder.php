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
        $categories = [
            [
                'key' => 'flights',
                'title' => 'رحلات'
            ],
            [
                'key' => 'cars',
                'title' => 'سيارات'
            ],
            [
                'key' => 'tours',
                'title' => 'جولات'
            ],
            [
                'key' => 'hotels',
                'title' => 'فنادق'
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
