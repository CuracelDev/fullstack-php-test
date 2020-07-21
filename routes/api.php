<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', function (Request $request) {
    return Product::all();
});

Route::get('products/{id}', function (Request $request, $id) {
    return Product::find($id);
});
