<?php

use App\Actions\Hmo\GetHmos;
use App\Actions\Order\CreateOrder;
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

Route::prefix('orders')->name('orders.')->group(static function () {
    Route::post('', [CreateOrder::class, 'asController'])->name('create');
});

Route::prefix('hmos')->name('hmos.')->group((static function () {
    Route::get('', [GetHmos::class, 'asController'])->name('all');
}));
