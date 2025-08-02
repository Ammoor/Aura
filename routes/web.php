<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAccountController;
use App\Http\Middleware\ApiKeyMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(ApiKeyMiddleware::class)->group(function () {

    Route::controller(AuthAccountController::class)->group(function () {

        Route::get('{provider_name}/redirect', 'redirect');

        Route::get('{provider_name}/callback', 'callback');
    });
});
