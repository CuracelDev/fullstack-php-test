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

    // get all users
    Route::get('/users', [UserController::class, 'index']);
    
    //get currently logged in user 
    Route::get('/current-user', [UserController::class, 'getCurrentLoggedInUser']);

    //add items to cart
    Route::post('/cart', [CartController::class, 'addCartItems']);
    
    //get cart belonging to client
    Route::get('/getcart', [CartController::class, 'index']);
    
    // create coupon
    Route::post('/coupon', [CouponController::class, 'store']);
    
    // get all coupons
    Route::get('/coupons', [CouponController::class, 'index']);
});
