<?php

use App\Http\Controllers\HmoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('submit-order');
});

Route::post('/hmos/batch-data', [HmoController::class, 'batchData']);
Route::get('/hmos/batch-data', [HmoController::class, 'retrieveBatchData']);
