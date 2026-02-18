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
| Expert Portal (PWA) – Google OAuth only
|--------------------------------------------------------------------------
*/
Route::prefix('expert')->name('expert.')->group(function () {
    Route::get('/', fn () => view('expert.landing'))->name('landing');
    Route::get('login', [\App\Http\Controllers\Expert\AuthController::class, 'showLogin'])->name('login');
    Route::get('auth/google', [\App\Http\Controllers\Expert\AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [\App\Http\Controllers\Expert\AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::middleware(['auth', 'user.not_banned'])->group(function () {
        Route::get('register', [\App\Http\Controllers\Expert\RegisterController::class, 'showForm'])->name('register');
        Route::post('register', [\App\Http\Controllers\Expert\RegisterController::class, 'submit'])->name('register.submit');
        Route::post('logout', [\App\Http\Controllers\Expert\AuthController::class, 'logout'])->name('logout');
        Route::middleware('expert')->group(function () {
            Route::get('dashboard', [\App\Http\Controllers\Expert\DashboardController::class, 'index'])->name('dashboard');
            Route::get('questions', [\App\Http\Controllers\Expert\QuestionController::class, 'index'])->name('questions.index');
            Route::get('questions/{post}', [\App\Http\Controllers\Expert\QuestionController::class, 'show'])->name('questions.show');
            Route::post('questions/{post}/answer', [\App\Http\Controllers\Expert\QuestionController::class, 'storeAnswer'])->name('questions.answer');
            Route::post('questions/{post}/solved', [\App\Http\Controllers\Expert\QuestionController::class, 'markSolved'])->name('questions.solved');
            Route::resource('articles', \App\Http\Controllers\Expert\ArticleController::class)->only(['index', 'create', 'store', 'edit', 'update'])->names('articles');
            Route::get('profile', [\App\Http\Controllers\Expert\ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('profile', [\App\Http\Controllers\Expert\ProfileController::class, 'update'])->name('profile.update');
        });
    });
});

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

        Route::prefix('community')->name('community.')->group(function () {
            Route::get('experts', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'index'])->name('experts.index');
            Route::get('experts/{expert_profile}', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'show'])->name('experts.show');
            Route::post('experts/{expert_profile}/approve', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'approve'])->name('experts.approve');
            Route::post('experts/{expert_profile}/reject', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'reject'])->name('experts.reject');
            Route::post('experts/{expert_profile}/suspend', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'suspend'])->name('experts.suspend');
            Route::post('experts/{expert_profile}/unsuspend', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'unsuspend'])->name('experts.unsuspend');
            Route::post('experts/{expert_profile}/toggle-verification', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'toggleVerification'])->name('experts.toggle-verification');
            Route::put('experts/{expert_profile}/notes', [\App\Http\Controllers\Admin\CommunityExpertController::class, 'updateNotes'])->name('experts.notes');
            Route::get('posts', [\App\Http\Controllers\Admin\CommunityPostController::class, 'index'])->name('posts.index');
            Route::get('posts/{post}', [\App\Http\Controllers\Admin\CommunityPostController::class, 'show'])->name('posts.show');
            Route::put('posts/{post}', [\App\Http\Controllers\Admin\CommunityPostController::class, 'update'])->name('posts.update');
            Route::delete('posts/{post}', [\App\Http\Controllers\Admin\CommunityPostController::class, 'destroy'])->name('posts.destroy');
            Route::delete('answers/{answer}', [\App\Http\Controllers\Admin\CommunityAnswerController::class, 'destroy'])->name('answers.destroy');
            Route::post('answers/{answer}/pin', [\App\Http\Controllers\Admin\CommunityAnswerController::class, 'pin'])->name('answers.pin');
            Route::post('answers/{answer}/unpin', [\App\Http\Controllers\Admin\CommunityAnswerController::class, 'unpin'])->name('answers.unpin');
            Route::post('answers/{answer}/best', [\App\Http\Controllers\Admin\CommunityAnswerController::class, 'markBest'])->name('answers.best');
            Route::get('reports', [\App\Http\Controllers\Admin\CommunityReportController::class, 'index'])->name('reports.index');
            Route::post('reports/{report}/resolve', [\App\Http\Controllers\Admin\CommunityReportController::class, 'resolve'])->name('reports.resolve');
            Route::post('reports/{report}/dismiss', [\App\Http\Controllers\Admin\CommunityReportController::class, 'dismiss'])->name('reports.dismiss');
            Route::resource('problem-categories', \App\Http\Controllers\Admin\ProblemCategoryController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names('problem-categories');
            Route::get('users', [\App\Http\Controllers\Admin\CommunityUserController::class, 'index'])->name('users.index');
            Route::post('users/{user}/suspend', [\App\Http\Controllers\Admin\CommunityUserController::class, 'suspend'])->name('users.suspend');
            Route::post('users/{user}/unsuspend', [\App\Http\Controllers\Admin\CommunityUserController::class, 'unsuspend'])->name('users.unsuspend');
            Route::post('users/{user}/ban', [\App\Http\Controllers\Admin\CommunityUserController::class, 'ban'])->name('users.ban');
            Route::post('users/{user}/unban', [\App\Http\Controllers\Admin\CommunityUserController::class, 'unban'])->name('users.unban');
            Route::get('articles', [\App\Http\Controllers\Admin\ExpertArticleController::class, 'index'])->name('articles.index');
            Route::get('articles/{article}', [\App\Http\Controllers\Admin\ExpertArticleController::class, 'show'])->name('articles.show');
            Route::post('articles/{article}/approve', [\App\Http\Controllers\Admin\ExpertArticleController::class, 'approve'])->name('articles.approve');
            Route::post('articles/{article}/feature', [\App\Http\Controllers\Admin\ExpertArticleController::class, 'feature'])->name('articles.feature');
            Route::delete('articles/{article}', [\App\Http\Controllers\Admin\ExpertArticleController::class, 'destroy'])->name('articles.destroy');
        });

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
