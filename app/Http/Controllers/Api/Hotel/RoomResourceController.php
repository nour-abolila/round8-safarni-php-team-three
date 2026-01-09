<?php
namespace App\Http\Controllers\Api\Hotel;

use App\Http\Controllers\Controller;
use App\Services\Hotel\RoomService;
use App\Http\Resources\Hotel\RoomDetailsResource;
use App\Helper\ApiResponse;

class RoomResourceController extends Controller
{
    protected RoomService $RoomService;

    public function __construct(RoomService $RoomService)
    {
        $this->RoomService = $RoomService;
    }

    public function show($id)
{
    $room = $this->RoomService->getRoomDetails($id);

        if (!$room) {
        
            return ApiResponse::error(
        
                null,
        
                'This room is not available',
        
                404
        );
    }

    return ApiResponse::success(new RoomDetailsResource($room));

    }
}
