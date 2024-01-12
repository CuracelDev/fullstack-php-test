<?php

use App\Actions\CreateOrderAction;
use App\Actions\GetAllHmoAction;
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

Route::prefix('orders')->name('order.')->group(static function () {
    Route::post('/', [CreateOrderAction::class, 'asController'])->name('create');
});

Route::prefix('hmos')->name('hmo.')->group((static function () {
    Route::get('/', [GetAllHmoAction::class, 'asController'])->name('index');
}));
