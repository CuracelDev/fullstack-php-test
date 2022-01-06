<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\OrderController;
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

Route::middleware('auth:api')
    ->get(
        '/user', function (Request $request) {
            return $request->user();
        }
    );

Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
Route::get('/get-orders', [OrderController::class, 'index'])->name('order.index');
Route::get(
    'batch/encounter/date', 
    [BatchController::class, 'batchByEncounterDate']
)->name('batch.encounter-date');
Route::get(
    'batch/sent/date', 
    [BatchController::class, 'batchBySentDate']
)->name('batch.send-date');
