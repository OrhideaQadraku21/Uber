<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VehicleController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API is working'
    ]);
});

// ===== AUTH (public) =====
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// ===== PROTECTED (needs Bearer token) =====
Route::middleware('auth:api')->group(function () {

    // auth
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    // vehicles (admin / later we will protect with role middleware)
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::post('/vehicles', [VehicleController::class, 'store']);

    // driver - get my vehicle
    Route::get('/driver/vehicle', [VehicleController::class, 'myVehicle']);
});
