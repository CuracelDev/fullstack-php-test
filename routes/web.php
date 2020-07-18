<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('users/login');
});

Route::get('/register', function () {
    return view('users/register');
});

Route::get('/coupons', function () {
    return view('coupons/index');
});

Route::get('/coupons/add', function () {
    return view('coupons/add');
});

Route::get('/products', function () {
    return view('products/index');
});

Route::get('/orders', function () {
    return view('orders/index');
});
