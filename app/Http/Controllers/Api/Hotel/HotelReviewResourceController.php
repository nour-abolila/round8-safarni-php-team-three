<?php

namespace App\Http\Controllers\Api\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Hotel\HotelReviewService;
use App\Http\Requests\Hotel\HotelReviewRequest;
use App\Http\Resources\Hotel\HotelReviewResource;
use App\Helper\ApiResponse;

class HotelReviewResourceController extends Controller
{
  
    public function __construct(HotelReviewService $service)
    {
        $this->service = $service;
    }


    public function store(HotelReviewRequest $request)
 
    {
 
        $review = $this->service->create(
 
            auth()->id(),
 
            $request->validated()
        );

        return ApiResponse::success(new HotelReviewResource($review));
    }

    public function index(Request $request)
    {
        $hotelId = $request->query('hotel_id');
        
        $reviews = $this->service->listHotelReviews($hotelId);

        return ApiResponse::success(HotelReviewResource::collection($reviews));
    }


}
