<?php

use App\Actions\GetBatches;
use App\Actions\GetHmoCodes;
use App\Actions\SubmitOrder;
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

Route::get('/hmos', GetHmoCodes::class);
Route::get('/hmo/{hmo}/batches', GetBatches::class);
Route::post('/submit-order', SubmitOrder::class);
