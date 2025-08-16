<?php

namespace App\Services\V1\Auth;

use App\Exceptions\InvalidUserCredentialsException;
use App\Models\User;
use App\Services\V1\UserService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected string $authMessage = 'Authentication successful.';

    public function __construct(
        private RefreshTokenService $refreshTokenService,
        private UserService $userService
    ){}

    public function register(array $data): JsonResponse
    {
        return $this->userService->save($data);
    }

    public function authenticate(array $data, ?string $clientType): JsonResponse
    {
        $credentials = array_merge($data, ['status' => 'active']);

        if (! Auth::attempt($credentials))
            throw new InvalidUserCredentialsException();

        $user = Auth::user();
        $user->load('role');

        $user->tokens()->delete();
        $tokens = $this->generateUserToken($user);

        if ($clientType !== 'web') {
            return Response::success(array_merge($tokens, ['user' => $user]), $this->authMessage);
        }

        $cookie = cookie('refresh_token', $tokens['refresh_token'], 60 * 24 * 7, '/', null, true, true);

        return Response::success([
            'user' => $user,
            'access_token' => $tokens['token']
        ], $this->authMessage)->withCookie($cookie);
    }

    private function generateUserToken(User $user): array
    {
        $token = $user->createToken(env('API_TOKEN_NAME'))->plainTextToken;
        $refreshToken = $this->refreshTokenService->createToken($user);

        return ['token' => $token, 'refresh_token' => $refreshToken];
    }
}
