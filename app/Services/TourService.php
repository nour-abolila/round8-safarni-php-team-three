<?php

namespace App\Services;

use App\Models\Tour;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TourService
{
    public function index(): Collection
    {
        return Tour::with(['images', 'reviews', 'schedules'])->get();
    }

    public function show(int $id): Tour
    {
        return Tour::with(['images', 'reviews.user', 'schedules'])->findOrFail($id);
    }

    public function compare(array $ids): Collection
    {
        return Tour::with(['images', 'reviews', 'schedules'])->whereIn('id', $ids)->get();
    }

    public function recommended(): LengthAwarePaginator
    {
        return Tour::with(['images', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->paginate(4);
    }

    public function available(): LengthAwarePaginator
    {
        return Tour::with(['images', 'reviews', 'schedules'])
            ->whereHas('schedules', function ($q) {
                $q->where('available_slots', '>', 0)->whereDate('start_date', '>=', now());
            })
            ->paginate(4);
    }
}

