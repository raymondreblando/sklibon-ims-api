<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class Response
{
    public static function success($data = null, $message = 'Success', $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function error($message = 'An error occurred', $statusCode = 422): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}
