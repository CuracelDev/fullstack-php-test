<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
	Route::get('/welcome', 'UserController@welcome');
	Route::post('/login', 'UserController@login');
	Route::post('/register', 'UserController@register');
	
	Route::get('/products', 'ProductController@products');
	Route::get('/products/{productId}', 'ProductController@getProduct');
	Route::post('/products/add', 'ProductController@add');
	
	Route::get('/coupons', 'CouponController@coupons');
	Route::post('/coupons/add', 'CouponController@add');
	
	Route::get('/orders', 'OrderController@orders');
	Route::post('/orders/add', 'OrderController@add');
	Route::delete('/orders/delete/{orderId}', 'OrderController@delete');
});