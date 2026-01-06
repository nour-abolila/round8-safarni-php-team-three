<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Hotel\HotelResourceController;
use App\Http\Controllers\Api\Hotel\RoomResourceController;
use App\Http\Controllers\Api\Hotel\HotelBookingResourceController;
use App\Http\Controllers\Api\Hotel\HotelReviewResourceController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('hotel', HotelResourceController::class) ->only(['index', 'show']); 

Route::apiResource('room', RoomResourceController::class) ->only(['show']);


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('hotel-bookings', HotelBookingResourceController::class)
    
    ->only(['index', 'store']); 

    Route::apiResource('hotel-review', HotelReviewResourceController::class)
    
    ->only(['index', 'store']); 
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

