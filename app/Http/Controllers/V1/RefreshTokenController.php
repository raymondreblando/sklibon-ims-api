<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\Auth\RefreshTokenService;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function __invoke(RefreshTokenService $refreshTokenService, Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        $clientType = $request->hasHeader('X-Client-Type') ? $request->header('X-Client-Type') : 'web';

        return $refreshTokenService->refresh($refreshToken, $clientType);
    }
}
