<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->group(function () {

        Route::post('logout', 'logout');
    });
});

Route::controller(UserController::class)->group(function () {

    Route::post('login', 'login');

    Route::post('register', 'register');
});
