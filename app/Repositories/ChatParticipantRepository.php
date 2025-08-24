<?php

namespace App\Repositories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Collection;

interface ChatParticipantRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(Chat $chat, array $data): Collection;
}
