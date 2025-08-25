<?php

namespace App\Traits\Auth;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

trait IssueApiTokens
{
    protected function generateUserToken(User $user): array
    {
        $token = $user->createToken(env('API_TOKEN_NAME'))->plainTextToken;

        $refreshToken = $this instanceof \App\Services\V1\Auth\RefreshTokenService
            ? $this->createToken($user)
            : $this->refreshTokenService->createToken($user);

        return ['token' => $token, 'refresh_token' => $refreshToken];
    }

    protected function issueApiToken(
        User $user,
        array $tokens,
        string $clientType
    ): JsonResponse {
        if ($clientType !== 'web') {
            return Response::success(array_merge($tokens, ['user' => $user]), $this->authMessage);
        }

        $cookie = cookie('refresh_token', $tokens['refresh_token'], 60 * 24 * 7, '/', null, true, true);

        return Response::success([
            'user' => new UserResource($user),
            'accessToken' => $tokens['token']
        ], $this->authMessage)->withCookie($cookie);
    }
}
