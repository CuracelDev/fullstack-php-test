<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthenticateController::class, 'login']);
    Route::get('/all-coupons', [CouponController::class, 'index']);
    Route::post('/create-coupon', [CouponController::class, 'store']);
    Route::get('/all-products', [ProductController::class, 'index']);


    Route::group(['middleware' => 'curacel'], function () {
        Route::get('/all-orders', [OrderController::class, 'index']);
        Route::post('/place-order', [OrderController::class, 'store']);
    });
});
