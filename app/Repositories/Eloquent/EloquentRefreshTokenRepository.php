<?php

namespace App\Repositories\Eloquent;

use App\Models\RefreshToken;
use App\Repositories\RefreshTokenRepository;

class EloquentRefreshTokenRepository implements RefreshTokenRepository
{
    public function findById(string $id): ?RefreshToken
    {
        return RefreshToken::findOrFail($id);
    }
}
