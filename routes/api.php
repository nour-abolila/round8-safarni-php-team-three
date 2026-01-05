<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/search-flights', [BookingController::class, 'searchFlights']);

Route::get('/flight-seats/{id}', [BookingController::class, 'getFlightSeat']);

Route::post('/book-flight/{flightId}', [BookingController::class, 'bookFlight']);
});

