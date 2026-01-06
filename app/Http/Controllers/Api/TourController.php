<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TourService;
use App\Http\Resources\Tours\TourCardResource;
use App\Http\Resources\Tours\TourDetailResource;
use App\Helper\ApiResponse;
use App\Http\Requests\Tours\CompareToursRequest;

class TourController extends Controller
{
    protected TourService $service;

    public function __construct(TourService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $tours = $this->service->index();
        return ApiResponse::success(TourCardResource::collection($tours));
    }

    public function show($id)
    {
        $tour = $this->service->show((int) $id);
        return ApiResponse::success(new TourDetailResource($tour));
    }

    public function compare(CompareToursRequest $request)
    {
        $tours = $this->service->compare($request->input('tour_ids'));
        return ApiResponse::success(TourCardResource::collection($tours));
    }

    public function recommended()
    {
        $tours = $this->service->recommended();
        return ApiResponse::success(TourCardResource::collection($tours));
    }

    public function available()
    {
        $tours = $this->service->available();
        return ApiResponse::success(TourCardResource::collection($tours));
    }
}
