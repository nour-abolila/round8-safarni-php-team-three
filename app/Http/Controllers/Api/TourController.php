<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with(['images', 'reviews', 'schedules'])->get()->map(function ($tour) {
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'slug' => $tour->slug,
                'duration' => $tour->duration,
                'visit_season' => $tour->visit_season,
                'activities' => $tour->activities,
                'recommendation' => $tour->recommendation,
                'image' => $tour->images->first()?->url,
                'rating_average' => round($tour->reviews->avg('rating'), 1),
                'reviews_count' => $tour->reviews->count(),
                // Assuming a default price or calculation since it's missing in DB
                'price' => 150 * $tour->duration,
            ];
        });

        return response()->json(['data' => $tours]);
    }

    public function show($id)
    {
        $tour = Tour::with(['images', 'reviews.user', 'schedules'])->findOrFail($id);

        $data = [
            'id' => $tour->id,
            'title' => $tour->title,
            'slug' => $tour->slug,
            'duration' => $tour->duration,
            'visit_season' => $tour->visit_season,
            'activities' => $tour->activities,
            'recommendation' => $tour->recommendation,
            'images' => $tour->images->pluck('url'),
            'reviews' => $tour->reviews->map(function ($review) {
                return [
                    'user' => $review->user->full_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment ?? '', // Assuming comment might be in additional fields or missing
                    'created_at' => $review->created_at,
                ];
            }),
            'rating_average' => round($tour->reviews->avg('rating'), 1),
            'reviews_count' => $tour->reviews->count(),
            'schedules' => $tour->schedules,
            'price' => 150 * $tour->duration,
        ];

        return response()->json(['data' => $data]);
    }

    public function compare(Request $request)
    {
        $request->validate([
            'tour_ids' => 'required|array|min:2|max:2',
            'tour_ids.*' => 'exists:tours,id',
        ]);

        $tours = Tour::with(['images', 'reviews', 'schedules'])->whereIn('id', $request->tour_ids)->get()->map(function ($tour) {
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'duration' => $tour->duration,
                'visit_season' => $tour->visit_season,
                'activities' => $tour->activities,
                'rating_average' => round($tour->reviews->avg('rating'), 1),
                'price' => 150 * $tour->duration,
                'image' => $tour->images->first()?->url,
            ];
        });

        return response()->json(['data' => $tours]);
    }

    public function recommended()
    {
        $tours = Tour::with(['images', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->paginate(4);

        $tours->getCollection()->transform(function ($tour) {
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'slug' => $tour->slug,
                'duration' => $tour->duration,
                'visit_season' => $tour->visit_season,
                'activities' => $tour->activities,
                'recommendation' => $tour->recommendation,
                'image' => $tour->images->first()?->url,
                'rating_average' => round($tour->reviews_avg_rating, 1),
                'reviews_count' => $tour->reviews->count(),
                'price' => 150 * $tour->duration,
            ];
        });

        return response()->json($tours);
    }

    public function available()
    {
        $tours = Tour::whereHas('schedules', function ($q) {
                $q->where('start_date', '>', now())
                  ->where('available_slots', '>', 0);
            })
            ->with(['images', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->paginate(4);

        $tours->getCollection()->transform(function ($tour) {
            return [
                'id' => $tour->id,
                'title' => $tour->title,
                'slug' => $tour->slug,
                'duration' => $tour->duration,
                'visit_season' => $tour->visit_season,
                'activities' => $tour->activities,
                'recommendation' => $tour->recommendation,
                'image' => $tour->images->first()?->url,
                'rating_average' => round($tour->reviews_avg_rating, 1),
                'reviews_count' => $tour->reviews->count(),
                'price' => 150 * $tour->duration,
            ];
        });

        return response()->json($tours);
    }
}
