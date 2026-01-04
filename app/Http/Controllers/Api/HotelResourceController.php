<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HotelService;
use App\Http\Resources\HotelResource;
use App\Http\Resources\HotelDetailsResource;
use App\Helper\ApiResponse;

class HotelResourceController extends Controller
{
    protected HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $hotels = $this->hotelService->getHotels();

        return ApiResponse::success(HotelResource::collection($hotels));
    }

    public function show($id)
    {
        $hotel = $this->hotelService->getHotelDetails($id); 

        return ApiResponse::success(new HotelDetailsResource($hotel));
    }
}
