<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CropController;
use App\Http\Controllers\Api\ThemeController;

/*
|--------------------------------------------------------------------------
| API Routes (Farming App / Mobile)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::get('theme', [ThemeController::class, 'index']);

    // Public: mobile sends OAuth access_token (from Google/Facebook SDK) or auth code for exchange
    Route::post('auth/google', [AuthController::class, 'google']);
    Route::post('auth/google/code', [AuthController::class, 'googleCode']);
    Route::post('auth/facebook', [AuthController::class, 'facebook']);
    Route::post('auth/facebook/code', [AuthController::class, 'facebookCode']);
    Route::post('auth/demo', [AuthController::class, 'demo']);

    // Protected (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [UserController::class, 'show']);
        Route::patch('user', [UserController::class, 'update']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('crops', [CropController::class, 'index']);
        Route::post('crops', [CropController::class, 'store']);
        Route::patch('crops/{id}', [CropController::class, 'update']);
        Route::delete('crops/{id}', [CropController::class, 'destroy']);
    });
});
