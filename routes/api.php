<?php

use App\Actions\Hmo\GetAllHmo;
use App\Actions\Order\SubmitOrder;
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

Route::prefix('orders')->name('orders.')->group(function () {
    Route::post('/', [SubmitOrder::class, 'asController'])->name('submit');
});

Route::prefix('hmos')->name('hmos.')->group(function () {
    Route::get('/', [GetAllHmo::class, 'asController'])->name('get');
});
