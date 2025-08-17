<?php

namespace App\Services\V1\Auth;

use App\Models\User;
use App\Repositories\RefreshTokenRepository;
use App\Traits\Auth\IssueApiTokens;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefreshTokenService
{
    use IssueApiTokens;

    protected string $authMessage = 'Token issued successfully.';

    public function __construct(
        private RefreshTokenRepository $refreshTokenRepository
    ){}

    public function createToken(User $user): string
    {
        $plainTextToken = Str::random(64);
        $hashedToken = hash('sha256', $plainTextToken);

        $user->refreshTokens()->delete();

        $user->refreshTokens()->create([
            'token' => $hashedToken,
            'expires_at' => now()->addDays(7)
        ]);

        return $plainTextToken;
    }

    public function refresh(string $token, string $clientType): JsonResponse
    {
        return DB::transaction(function () use ($token, $clientType) {
            $hashedToken = hash('sha256', $token);
            $refreshToken = $this->refreshTokenRepository->findByToken($hashedToken);

            $refreshToken->load('user');
            $user = $refreshToken->user;

            $user->tokens()->delete();
            $user->refreshTokens()->delete();

            $tokens = $this->generateUserToken($user);
            return $this->issueApiToken($user, $tokens, $clientType);
        });
    }

    public function verify(string $token)
    {
        $hashedToken = hash('sha256', $token);
        $refreshToken = $this->refreshTokenRepository->findByToken($hashedToken);

        return ! $refreshToken || $refreshToken->expires_at < now() ? false : true;
    }
}
