<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\BookingController;
use App\Models\User;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelResourceController;
use App\Http\Controllers\Api\RoomResourceController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//! test login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


//! tours
Route::prefix('tours')->group(function () {
    Route::get('/', [TourController::class, 'index']);
    Route::get('/recommended', [TourController::class, 'recommended']);
    Route::get('/available', [TourController::class, 'available']);
    Route::post('/compare', [TourController::class, 'compare']);
    Route::get('/{id}', [TourController::class, 'show']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    //! favorites
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index']);
        Route::post('/', [FavoriteController::class, 'store']);
        Route::delete('/{tourId}', [FavoriteController::class, 'destroy']);
    });

    //! bookings
    Route::post('/bookings', [BookingController::class, 'store']);
});

//! hotel
Route::apiResource('hotel', HotelResourceController::class) ->only(['index', 'show']);
Route::apiResource('room', RoomResourceController::class) ->only(['show']);


