<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\FavoriteService;
use App\Http\Resources\Favorites\FavoriteResource;
use App\Helper\ApiResponse;
use App\Http\Requests\Favorites\StoreFavoriteRequest;

class FavoriteController extends Controller
{
    protected FavoriteService $service;

    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = Auth::user();
        $favorites = $this->service->list($user);
        return ApiResponse::success(FavoriteResource::collection($favorites));
    }

    public function store(StoreFavoriteRequest $request)
    {
        $user = Auth::user();
        $favorite = $this->service->add($user, (int) $request->tour_id);
        return ApiResponse::success($favorite, 'Tour added to favorites');
    }

    public function destroy($tourId)
    {
        $user = Auth::user();
        $this->service->remove($user, (int) $tourId);
        return ApiResponse::success(null, 'Tour removed from favorites');
    }
}
