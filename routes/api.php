<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MailController;
use App\Http\Middleware\ApiKeyMiddleware;

Route::middleware(ApiKeyMiddleware::class)->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::controller(UserController::class)->group(function () {

            Route::get('user', 'getUserData');

            /**
             * We used the POST method here instead of PUT/PATCH for the update because Postman form-data body does not parse it natively.
             */

            Route::post('user', 'updateUserData');

            Route::delete('user', 'deleteUserData');

            Route::post('logout', 'logout');
        });

        Route::controller(DocumentController::class)->group(function () {

            Route::post('documents', 'uploadDocument');

            Route::get('documents/{document_id}', 'getDocument');

            Route::get('documents', 'getDocuments');
        });
    });

    Route::controller(UserController::class)->group(function () {

        Route::post('login', 'login');

        Route::post('register', 'register');
    });

    Route::controller(MailController::class)->group(function () {

        Route::post('email/verify', 'verifyEmail');

        Route::post('email/resend', 'resendEmail');
    });
});
