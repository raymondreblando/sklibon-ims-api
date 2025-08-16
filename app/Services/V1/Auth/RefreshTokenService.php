<?php

namespace App\Services\V1\Auth;

use App\Models\User;
use App\Repositories\RefreshTokenRepository;
use Illuminate\Support\Str;

class RefreshTokenService
{
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
}
