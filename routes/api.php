<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HmoController;
use App\Http\Controllers\ProviderController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('providers', [ProviderController::class, 'index']);

Route::get('hmos', [HmoController::class, 'index']);
Route::get('hmos/{id}/batch-orders', [HmoController::class, 'batchOrder']);
Route::get('hmos/{id}/notify', [HmoController::class, 'sendNotification']);

Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'create']);
