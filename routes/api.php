<?php

use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Trader\AdsController;
use App\Http\Controllers\Trader\CategoryController;
use App\Http\Controllers\Trader\PostController;
use App\Http\Controllers\Trader\StoreHoursController;
use App\Http\Controllers\TraderAnalyticsController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\Trader\AuthController as TraderAuthController;
use App\Http\Controllers\VersionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/categories', [CategoryController::class, 'index']);
Route::controller(UserAuthController::class)->prefix('/user')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
Route::controller(TraderAuthController::class)->prefix('/trader')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/update/profile', 'updateProfile');
        Route::get('/get/profile', 'getProfile');
        Route::post('/change/password', 'changePassword');
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/logout', [UserAuthController::class, 'logout']);
    Route::post('user/update/profile', [UserAuthController::class, 'updateProfile']);
    Route::get('user/get/profile', [UserAuthController::class, 'getProfile']);
    Route::get('trader/logout', [TraderAuthController::class, 'logout']);
    Route::post('/posts/create', [PostController::class, 'create_post']);
    Route::get('/posts/mine', [PostController::class, 'get_my_posts']);
    Route::post('/posts/delete/{post}', [PostController::class, 'delete_post']);
    Route::post('/ads/create', [AdsController::class, 'create_ads']);
    Route::get('/ads/mine', [AdsController::class, 'get_my_ads']);
    Route::post('/ads/delete/{ads}', [AdsController::class, 'delete_ads']);
    Route::post('post/like/{post}', [PostController::class, 'likePost']);
    Route::post('post/dislike/{post}', [PostController::class, 'dislikePost']);
    Route::get('get/point', [\App\Http\Controllers\Trader\PointController::class, 'getPoint']);
    Route::get('get/wallet', [\App\Http\Controllers\Trader\PointController::class, 'getWallet']);
    Route::post('RechargeByCode', [\App\Http\Controllers\Trader\PointController::class, 'rechargePoint']);



    Route::controller(\App\Http\Controllers\User\UserOperationController::class)->prefix('/user')->group(function () {
        Route::post('/get_ads', 'getAds');
        Route::get('getStore_byCat/{id}', 'GetStore');
        Route::get('search', 'search');
        Route::get('/add_to_favorite/{adv_id}', 'toggleFavorite');
        Route::get('/add_store_to_favorite/{store_id}', 'toggleStoreFavorite');
        Route::get('show_store/{id}', 'show');
        Route::post('search/store', 'searchStore');
        Route::get('favoriteAdv', 'showfavorite');
        Route::get('favoriteStores', 'showfavoriteStore');
        Route::get('block/store/{id}', 'toggleStoreBlock');
        Route::get('blocked/stores', 'getBlockedStores');
        Route::post('rate', 'rate');
    });
});
Route::controller(\App\Http\Controllers\User\UserOperationController::class)->prefix('/user')->group(function () {
    Route::get('/get_posts', 'getPost');
    Route::post('/guest/get_ads', 'getAds');
    Route::get('guest/search', 'search');
    Route::get('guest/getStore_byCat/{id}', 'GetStore');
    Route::get('getStore_Post/{id}', 'getStorePosts');
    Route::get('getStore_pyAdv/{id}', 'getStoreByAdv');
    Route::get('guest/show_store/{id}', 'show');
    Route::post('guest/search/store', 'searchStore');
    Route::get('getStore_Ads/{id}', 'getStoreAds');
    Route::get('rate/{id}', 'getRates');
});


Route::get('/support', [SupportController::class, 'index']);
Route::middleware('auth:sanctum')->post('/update/version', [VersionsController::class, 'update']);
Route::get('/version', [VersionsController::class, 'index']);
Route::get('/cities', [UserAuthController::class, 'getCities']);

// Advanced Search
Route::post('/search/advanced', [SearchController::class, 'advancedSearch']);

// Trader Analytics (Protected)
Route::middleware('auth:sanctum')->prefix('trader/analytics')->group(function () {
    Route::get('/overview', [TraderAnalyticsController::class, 'getOverview']);
    Route::get('/ads', [TraderAnalyticsController::class, 'getAdsAnalytics']);
    Route::get('/chart', [TraderAnalyticsController::class, 'getChartData']);
});

// Promotions
Route::get('/promotion-packages', [PromotionController::class, 'getPackages']);
Route::get('/ads/featured', [PromotionController::class, 'getFeaturedAds']);

// Trader Promotion (Protected)
Route::middleware('auth:sanctum')->post('/trader/ads/{id}/promote', [PromotionController::class, 'promoteAd']);

// Ad Scheduling (Protected)
Route::middleware('auth:sanctum')->prefix('trader/ads')->group(function () {
    Route::put('/{id}/status', [AdsController::class, 'updateStatus']);
    Route::get('/scheduled', [AdsController::class, 'getScheduled']);
    Route::get('/expired', [AdsController::class, 'getExpired']);
    Route::post('/{id}/renew', [AdsController::class, 'renew']);
});

// Store Hours (Protected)
Route::middleware('auth:sanctum')->prefix('trader/store')->group(function () {
    Route::get('/hours', [StoreHoursController::class, 'getHours']);
    Route::post('/hours', [StoreHoursController::class, 'updateHours']);
});

// Reports
Route::get('/reports/reasons', [ReportController::class, 'getReasons']);

// Protected Report Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reports', [ReportController::class, 'store']);
    Route::get('/user/reports', [ReportController::class, 'getUserReports']);
});
