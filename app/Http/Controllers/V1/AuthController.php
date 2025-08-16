<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Services\V1\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ){}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->authService->register($data);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $clientType = $request->hasHeader('X-Client-Type') ? $request->header('X-Client-Type') : 'web';

        return $this->authService->authenticate($data, $clientType);
    }
}
