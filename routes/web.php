<?php

use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): JsonResponse {
    return Response::error('Not Found', 404);
});
