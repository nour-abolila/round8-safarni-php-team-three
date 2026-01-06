<?php

use App\Http\Controllers\TourController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\BookingController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//! test login
Route::post('/test-login', function () {
    $user = User::firstOrCreate(
        ['email' => 'test@example.com'],
        ['full_name' => 'Test User', 'password' => bcrypt('password')]
    );

    $token = $user->createToken('test-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

//! tours
Route::prefix('tours')->group(function () {
    Route::get('/', [TourController::class, 'index']);
    Route::post('/compare', [TourController::class, 'compare']);
    Route::get('/{id}', [TourController::class, 'show']);
});

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
