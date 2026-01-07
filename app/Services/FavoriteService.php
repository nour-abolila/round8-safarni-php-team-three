<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FavoriteService
{
    public function list(User $user): Collection
    {
        return $user->favorites()
            ->where('favorable_type', Tour::class)
            ->with(['favorable.images', 'favorable.reviews'])
            ->get();
    }

    public function add(User $user, int $tourId)
    {
        return $user->favorites()->firstOrCreate([
            'favorable_type' => Tour::class,
            'favorable_id' => $tourId,
        ]);
    }

    public function remove(User $user, int $tourId): void
    {
        $user->favorites()
            ->where('favorable_type', Tour::class)
            ->where('favorable_id', $tourId)
            ->delete();
    }
}

