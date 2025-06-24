<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthAccountController::class)->group(function () {

    Route::get('{provider_name}/redirect', 'redirect');

    Route::get('{provider_name}/callback', 'callback');
});
