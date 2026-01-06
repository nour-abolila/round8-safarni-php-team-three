<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->where('favorable_type', Tour::class)
            ->with(['favorable.images', 'favorable.reviews'])
            ->get()
            ->map(function ($fav) {
                $tour = $fav->favorable;
                if (!$tour) return null;

                return [
                    'id' => $tour->id,
                    'title' => $tour->title,
                    'image' => $tour->images->first()?->url,
                    'duration' => $tour->duration,
                    'rating_average' => round($tour->reviews->avg('rating'), 1),
                ];
            })->filter();

        return response()->json(['data' => $favorites->values()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
        ]);

        $user = Auth::user();

        $favorite = $user->favorites()->firstOrCreate([
            'favorable_type' => Tour::class,
            'favorable_id' => $request->tour_id,
        ]);

        return response()->json(['message' => 'Tour added to favorites', 'data' => $favorite]);
    }

    public function destroy($tourId)
    {
        $user = Auth::user();

        $user->favorites()->where('favorable_type', Tour::class)
            ->where('favorable_id', $tourId)
            ->delete();

        return response()->json(['message' => 'Tour removed from favorites']);
    }
}
