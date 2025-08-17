<?php

namespace App\Repositories;

use App\Models\RefreshToken;

interface RefreshTokenRepository
{
    public function findByToken(string $token): ?RefreshToken;
}
