<?php

use App\Actions\FetchAvailableHMOsAction;
use App\Actions\SaveOrderItemsAction;
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

Route::get('available-hmos', FetchAvailableHMOsAction::class)
    ->name('available-hmos');

Route::post('/order-items/submit', SaveOrderItemsAction::class)
    ->middleware(['throttle:4,1'])
    ->name('order-items.submit');
