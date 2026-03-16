<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\DriverController;

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

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        // ---- DRIVERS (ADMIN)
        Route::prefix('drivers')->group(function () {
            Route::get('/', [DriverController::class, 'index']);   // GET /api/drivers
            Route::post('/', [DriverController::class, 'store']);  // POST /api/drivers
        });

        // ---- VEHICLES (ADMIN)
        Route::prefix('vehicles')->group(function () {
            Route::get('/', [VehicleController::class, 'index']);  // GET /api/vehicles
            Route::post('/', [VehicleController::class, 'store']); // POST /api/vehicles
        });

        // (ma vonë: dashboard, users, etj.)
    });

    /*
    |--------------------------------------------------------------------------
    | DRIVER ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:driver')->group(function () {

        Route::prefix('driver')->group(function () {
            Route::get('/vehicle', [VehicleController::class, 'myVehicle']); // GET /api/driver/vehicle
        });

        // (ma vonë: rides, online/offline, etj.)
    });
});