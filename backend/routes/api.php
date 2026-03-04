<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All routes here are automatically prefixed with /api
*/

Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API is working'
    ]);
});

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| PROTECTED (JWT Bearer)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {

    // ---- AUTH (protected)
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });

    // ---- VEHICLES
    Route::prefix('vehicles')->group(function () {
        Route::get('/', [VehicleController::class, 'index']);     // GET /api/vehicles
        Route::post('/', [VehicleController::class, 'store']);    // POST /api/vehicles
    });

    // ---- DRIVER
    Route::prefix('driver')->group(function () {
        Route::get('/vehicle', [VehicleController::class, 'myVehicle']); // GET /api/driver/vehicle
    });
});
