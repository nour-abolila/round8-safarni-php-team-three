<?php
namespace Database\Seeders;

use App\Models\Category;
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
                'title' => 'رحلات',
                'image' => 'https://i.pinimg.com/1200x/9b/5c/d9/9b5cd9b6019ef4555a699637d7a4eca2.jpg'
            ],
            [
                'key' => 'cars',
                'title' => 'سيارات',
                'image' => 'https://i.pinimg.com/736x/65/0a/af/650aafa5e5c27d77fb5197b610e37132.jpg'
            ],
            [
                'key' => 'tours',
                'title' => 'جولات',
                'image' => 'https://i.pinimg.com/1200x/f9/4c/58/f94c5898fcc5227a6b969b303bf8a1b6.jpg'
            ],
            [
                'key' => 'hotels',
                'title' => 'فنادق',
                'image' => 'https://i.pinimg.com/1200x/e0/73/04/e073047a8a95f95a6af23a5b3f2dfe63.jpg'
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['key' => $categoryData['key']],
                ['title' => $categoryData['title']]
            );

            // Update or Create image
            if ($category->images()->exists()) {
                $category->images()->update(['url' => $categoryData['image']]);
            } else {
                $category->images()->create(['url' => $categoryData['image']]);
            }
        }
    }
}
