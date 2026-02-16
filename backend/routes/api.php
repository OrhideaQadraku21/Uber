<?php

use Illuminate\Support\Facades\Route;


Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API is working'
    ]);
});
