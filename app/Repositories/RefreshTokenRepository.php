<?php

namespace App\Repositories;

use App\Models\RefreshToken;

interface RefreshTokenRepository
{
    public function findById(string $id): ?RefreshToken;
}
