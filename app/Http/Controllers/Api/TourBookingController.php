<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookings\StoreTourBookingRequest;
use App\Http\Resources\Bookings\TourBookingResource;
use App\Services\BookingServices\TourBookingService;
use Illuminate\Http\Request;

class TourBookingController extends Controller
{
    public function __construct(protected TourBookingService $tourBookingService)
    {}

    /**
     * Book a tour
     */
    public function store(StoreTourBookingRequest $request)
    {
        $result = $this->tourBookingService->bookTour($request->validated());
        
        if (is_array($result) && isset($result['status']) && $result['status'] === 'error') {
            return ApiResponse::error($result['message'], $result['statusCode'] ?? 400);
        }

        return ApiResponse::success(
            new TourBookingResource($result),
            'تم حجز الجولة بنجاح'
        );
    }

    /**
     * Get user's tour bookings
     */
    public function index(Request $request)
    {
        $bookings = $this->tourBookingService->getUserBookings();
        
        return ApiResponse::success(
            TourBookingResource::collection($bookings),
            'تم جلب حجوزات الجولات بنجاح'
        );
    }

    /**
     * Get specific booking details
     */
    public function show($bookingId)
    {
        try {
            $booking = $this->tourBookingService->getBookingDetails($bookingId);
            
            return ApiResponse::success(
                new TourBookingResource($booking),
                'تم جلب تفاصيل الحجز بنجاح'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('الحجز غير موجود', 404);
        }
    }
}