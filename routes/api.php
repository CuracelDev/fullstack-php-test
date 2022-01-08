<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
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

Route::post('/login', [LoginController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);

Route::group(["middleware" => "auth:api"], function(){

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/current-user', [UserController::class, 'getCurrentLoggedInUser']);

    Route::post('/cart', [CartController::class, 'addCartItems']);
    Route::get('/getcart', [CartController::class, 'index']);
    
    Route::post('/coupon', [CouponController::class, 'store']);
    Route::get('/coupons', [CouponController::class, 'index']);
});
