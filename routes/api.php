<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products', 'Api\ProductController')->only(['index', 'show']);
Route::apiResource('coupons', 'Api\CouponController')->only(['index', 'store']);
Route::get('users', 'Api\UserController@index');
