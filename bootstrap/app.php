<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Helpers\ApiResponseFormat;
use function Illuminate\Log\log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {
            //error types not listed will be caught by instanceof Exception as 500
            //Add more error types as needed
            //dump($e->getMessage(), $e->getCode(), get_class($e));
            if ($e instanceof AuthenticationException) {

                return ApiResponseFormat::failedResponse(401, "Unauthorized");
            }
            if ($e instanceof AccessDeniedHttpException) {

                return ApiResponseFormat::failedResponse(403, "Forbidden action");
            }
            //Route not found and Model not found use this error
            if ($e instanceof NotFoundHttpException) {
                return ApiResponseFormat::failedResponse(404, $e->getMessage());
            }
            if ($e instanceof ValidationException) {

                return ApiResponseFormat::failedResponse(422, 'Validation failed.', $e->errors());
            }

            if ($e instanceof Exception) {

                $code = $e->getCode();
                if (!is_int($code) || $code < 100) $code = 500;

                //Hide unknown exceptions on production
                if (config('app.debug')) {

                    $message = "Unhandled Exception: " . $e->getMessage() . "    Trace:" . $e->getTraceAsString();
                    return ApiResponseFormat::failedResponse($e, $code, $message);
                } else {

                    return ApiResponseFormat::failedResponse('Something went wrong on the server.', $code);
                }
            }
        });
    })->create();
