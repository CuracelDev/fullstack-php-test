<?php

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

 //Hmo
 Route::group(['namespace' => 'Hmo', 'prefix' => 'hmo'], function() {
    Route::get('list', 'LoadController@index');
});

 //Orders
 Route::group(['namespace' => 'Orders', 'prefix' => 'orders'], function() {
    Route::get('get/id', 'LoadController@get');
    Route::get('list', 'LoadController@index');
    Route::post('save', 'LoadController@store');
});

