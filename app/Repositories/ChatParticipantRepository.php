<?php

namespace App\Repositories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Collection;

interface ChatParticipantRepository
{
    public function create(Chat $chat, array $data): Collection;
    public function find(array $criteria = []): bool;
}
