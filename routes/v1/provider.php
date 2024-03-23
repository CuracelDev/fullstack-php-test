<?php

use App\Http\Controllers\Provider\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/provider')->group(function () {

    Route::post('submit-order', [OrderController::class, 'store']);

});
