<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PaymentWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelResourceController;
use App\Http\Controllers\Api\RoomResourceController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('hotel', HotelResourceController::class) ->only(['index', 'show']);

Route::apiResource('room', RoomResourceController::class) ->only(['show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/search-flights', [BookingController::class, 'searchFlights']);

    Route::get('/flight-seats/{id}', action: [BookingController::class, 'getFlightSeat']);

    Route::post('/book-flight/{flightId}', [BookingController::class, 'bookFlight']);

    Route::post('/book-car', [BookingController::class, 'bookCar']);

    Route::post('search-car', [BookingController::class, 'searchCar']);

    Route::post('create-payment-intent/{bookingId}', [PaymentController::class, 'makePayment']);
});

Route::post('webhook/stripe', [PaymentWebhookController::class, 'handle']);


