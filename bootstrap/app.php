<?php

use App\Exceptions\InvalidUserCredentialsException;
use App\Utils\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (InvalidUserCredentialsException $e) {
            return Response::error($e->getMessage(), $e->getCode());
        });

        $exceptions->render(function (QueryException $e) {
            return Response::error('Database error occurred. Please contact support.', 500);
        });

        $exceptions->render(function (ModelNotFoundException $e) {
            return Response::error('Resource not found.', 404);
        });
    })->create();
