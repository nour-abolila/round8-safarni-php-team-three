<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Review;
use App\Models\Tour;
use App\Models\TourSchedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a user for reviews
        $user = User::first() ?? User::factory()->create([
            'full_name' => 'Reviewer User',
            'email' => 'reviewer@example.com',
        ]);

        $tours = [
            [
                'title' => 'Magical Paris',
                'slug' => 'magical-paris',
                'price' => 1200.00,
                'duration' => 5,
                'visit_season' => 'Spring',
                'activities' => ['Eiffel Tower Visit', 'Seine River Cruise', 'Louvre Museum'],
                'recommendation' => 'Perfect for couples and art lovers.',
            ],
            [
                'title' => 'Safari Adventure in Kenya',
                'slug' => 'safari-kenya',
                'price' => 2500.00,
                'duration' => 7,
                'visit_season' => 'Summer',
                'activities' => ['Game Drive', 'Masai Mara Visit', 'Camping'],
                'recommendation' => 'Bring good binoculars and a camera.',
            ],
            [
                'title' => 'Kyoto Cultural Tour',
                'slug' => 'kyoto-cultural',
                'price' => 1800.00,
                'duration' => 4,
                'visit_season' => 'Autumn',
                'activities' => ['Tea Ceremony', 'Temple Visits', 'Bamboo Forest Walk'],
                'recommendation' => 'Wear comfortable walking shoes.',
            ],
        ];

        foreach ($tours as $tourData) {
            $tour = Tour::updateOrCreate(
                ['slug' => $tourData['slug']],
                $tourData
            );

            // Add Images
            if (!$tour->images()->exists()) {
                $tour->images()->create([
                    'url' => 'https://placehold.co/600x400?text=' . urlencode($tour->title),
                ]);
            }

            // Add Schedule
            if (!$tour->schedules()->exists()) {
                TourSchedule::create([
                    'tour_id' => $tour->id,
                    'start_date' => now()->addDays(10),
                    'capacity' => 20,
                    'available_slots' => 20,
                ]);
            }

            // Add Review
            if (!$tour->reviews()->exists()) {
                $tour->reviews()->create([
                    'user_id' => $user->id,
                    'comment' => 'Great tour!',
                    'rating' => rand(4, 5),
                    'status' => 'approved',
                ]);
            }
        }
    }
}
