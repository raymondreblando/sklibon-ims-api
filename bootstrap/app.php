<?php

use App\Exceptions\InvalidRefreshTokenException;
use App\Exceptions\InvalidUserCredentialsException;
use App\Utils\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $exceptions->render(
            fn (InvalidRefreshTokenException $e) => Response::error($e->getMessage(), $e->getCode())
        );

        $exceptions->render(
            fn (InvalidUserCredentialsException $e) => Response::error($e->getMessage(), $e->getCode())
        );

        $exceptions->render(
            fn (QueryException $e): JsonResponse => Response::error('Database error occurred. Please contact support.', 500)
        );

        $exceptions->render(
            fn (ModelNotFoundException|NotFoundHttpException $e) => Response::error('Resource not found.', 404)
        );

        $exceptions->render(
            fn (AccessDeniedHttpException $e): JsonResponse => Response::error('Resource not found.', 404)
        );

        $exceptions->render(function (Throwable $e): JsonResponse|null {
            if ($e instanceof ValidationException) return null;

            if ($e instanceof AuthenticationException)
                return Response::error('Session expired.', 401);

            return Response::error('Something went wrong. Please try again later.', 500);
        });
    })->create();
