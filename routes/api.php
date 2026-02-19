<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CropController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\CommunityPostController;
use App\Http\Controllers\Api\CommunityActionController;
use App\Http\Controllers\Api\CommunityDataController;
use App\Http\Controllers\Api\WeatherController;

/*
|--------------------------------------------------------------------------
| API Routes (Farming App / Mobile)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::get('theme', [ThemeController::class, 'index']);

    // Community dropdown data (public for feed; auth optional for posting)
    Route::get('community/crops', [CommunityDataController::class, 'crops']);
    Route::get('community/problem-categories', [CommunityDataController::class, 'problemCategories']);

    // Public: mobile sends OAuth access_token (from Google/Facebook SDK) or auth code for exchange
    Route::get('auth/google/redirect', [AuthController::class, 'googleRedirect']); // Google redirects here, we redirect to app
    Route::post('auth/google', [AuthController::class, 'google']);
    Route::post('auth/google/code', [AuthController::class, 'googleCode']);
    Route::post('auth/facebook', [AuthController::class, 'facebook']);
    Route::post('auth/facebook/code', [AuthController::class, 'facebookCode']);
    Route::post('auth/demo', [AuthController::class, 'demo']);

    // Protected (Sanctum) – farmers
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [UserController::class, 'show']);
        Route::patch('user', [UserController::class, 'update']);
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('crops/catalog', [CropController::class, 'catalog']);
        Route::get('crops', [CropController::class, 'index']);
        Route::post('crops', [CropController::class, 'store']);
        Route::patch('crops/{id}', [CropController::class, 'update']);
        Route::delete('crops/{id}', [CropController::class, 'destroy']);

        // Weather (location-based, refresh every 4 hours)
        Route::get('weather', [WeatherController::class, 'show']);
        Route::post('weather/refresh', [WeatherController::class, 'refresh']);

        // Community
        Route::get('community/posts', [CommunityPostController::class, 'index']);
        Route::post('community/posts', [CommunityPostController::class, 'store']);
        Route::get('community/posts/{id}', [CommunityPostController::class, 'show']);
        Route::post('community/posts/{id}/like', [CommunityActionController::class, 'likePost']);
        Route::post('community/answers/{id}/like', [CommunityActionController::class, 'likeAnswer']);
        Route::post('community/comments', [CommunityActionController::class, 'storeComment']);
        Route::post('community/follow/{userId}', [CommunityActionController::class, 'follow']);
        Route::post('community/report', [CommunityActionController::class, 'report']);
    });
});
