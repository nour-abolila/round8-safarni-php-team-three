<?php
namespace App\Http\Controllers\Api\Hotel;

use App\Http\Controllers\Controller;
use App\Services\HotelService;
use App\Http\Resources\Hotel\HotelResource;
use App\Http\Resources\Hotel\HotelDetailsResource;
use App\Helper\ApiResponse;
use Illuminate\Http\Request;

class HotelResourceController extends Controller
{
    protected HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index(Request $request)
    {
         $lat = $request->query('lat'); 

         $lng = $request->query('lng'); 

        $hotels = $this->hotelService->getHotels($lat, $lng);

        return ApiResponse::success(HotelResource::collection($hotels));
    }

    public function show($id, Request $request)
    {
        $roomsPerPage = $request->query('rooms_per_page', 5); 
    
        $hotel = $this->hotelService->getHotelDetails($id, $roomsPerPage);

        return ApiResponse::success(new HotelDetailsResource($hotel));
    }
}
