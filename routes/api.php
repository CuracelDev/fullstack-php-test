<?php

use App\Http\Controllers\Api\V1\LookupController;
use App\Http\Controllers\Api\V1\User\SearchUsernameController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\File;
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


foreach (File::allFiles(__DIR__ . '/v1') as $route_file) {
    require $route_file->getPathname();
}

