<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website (front-end) Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/features', [PageController::class, 'feature'])->name('feature');
Route::get('/schemes', [PageController::class, 'schemeIndex'])->name('scheme.index');
Route::get('/schemes/{slug}', [PageController::class, 'schemeShow'])->name('scheme.show');
Route::get('/crops', [PageController::class, 'cropIndex'])->name('crop.index');
Route::get('/crops/{slug}', [PageController::class, 'cropShow'])->name('crop.show');
Route::get('/irrigation', [PageController::class, 'irrigationIndex'])->name('irrigation.index');
Route::get('/irrigation/{slug}', [PageController::class, 'irrigationShow'])->name('irrigation.show');
Route::get('/blog', [PageController::class, 'blogIndex'])->name('blog.index');
Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/terms', [PageController::class, 'term'])->name('term');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest-only: login form and attempt
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');

        Route::resource('crop-categories', \App\Http\Controllers\Admin\CropCategoryController::class)->names('crop-categories');
        Route::resource('crops', \App\Http\Controllers\Admin\CropController::class)->names('crops');
        Route::resource('scheme-categories', \App\Http\Controllers\Admin\SchemeCategoryController::class)->names('scheme-categories');
        Route::resource('schemes', \App\Http\Controllers\Admin\SchemeController::class)->names('schemes');
        Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->names('blog-categories');
        Route::resource('blog-posts', \App\Http\Controllers\Admin\BlogPostController::class)->names('blog-posts');
        Route::get('pages', [\App\Http\Controllers\Admin\StaticPageController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}/edit', [\App\Http\Controllers\Admin\StaticPageController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [\App\Http\Controllers\Admin\StaticPageController::class, 'update'])->name('pages.update');
        Route::resource('irrigation-categories', \App\Http\Controllers\Admin\IrrigationCategoryController::class)->names('irrigation-categories');
        Route::resource('irrigation-methods', \App\Http\Controllers\Admin\IrrigationMethodController::class)->names('irrigation-methods');
    });
});
