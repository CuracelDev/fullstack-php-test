<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::apiResource('products', 'Api\ProductController')->only(['index', 'show']);
Route::apiResource('coupons', 'Api\CouponController')->only(['index', 'store']);
Route::get('users', 'Api\UserController@index');
Route::get('products/{product}/price', 'Api\PriceController');
