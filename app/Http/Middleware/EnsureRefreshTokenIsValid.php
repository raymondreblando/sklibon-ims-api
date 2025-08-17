<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidRefreshTokenException;
use App\Services\V1\Auth\RefreshTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRefreshTokenIsValid
{
    public function __construct(
        private RefreshTokenService $refreshTokenService
    ){}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! ($request->isMethod('POST') && $request->hasCookie('refresh_token')))
            throw new InvalidRefreshTokenException();

        $isValidToken = $this->refreshTokenService->verify($request->cookie('refresh_token'));

        if (! $isValidToken)
            throw new InvalidRefreshTokenException();

        return $next($request);
    }
}
