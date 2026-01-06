<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelBookingRequest;
use App\Services\BookingServices\HotelBookingService;
use App\Http\Resources\HotelBookingResource;
use App\Helper\ApiResponse;

class HotelBookingResourceController extends Controller
{
    protected HotelBookingService $service;

    public function __construct(HotelBookingService $service)
    {
        $this->service = $service;
    }

    public function store(HotelBookingRequest $request)
    {
        $booking = $this->service->book(auth()->id(), $request->validated());

        return ApiResponse::success(new HotelBookingResource($booking));
    }

    public function index()
    {
        $bookings = $this->service->listUserBookings(auth()->id());

        return ApiResponse::success(HotelBookingResource::collection($bookings));
    }
}
