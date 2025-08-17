<?php

namespace App\Repositories\Eloquent;

use App\Models\RefreshToken;
use App\Repositories\RefreshTokenRepository;

class EloquentRefreshTokenRepository implements RefreshTokenRepository
{
    public function findByToken(string $token): ?RefreshToken
    {
        return RefreshToken::where('token', $token)->first();
    }
}
