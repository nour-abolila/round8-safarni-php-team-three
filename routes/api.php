<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelResourceController;
use App\Http\Controllers\Api\RoomResourceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('hotel', HotelResourceController::class) ->only(['index', 'show']); 

Route::apiResource('room', RoomResourceController::class) ->only(['show']);
