<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\User;

interface ChatRepository
{
    public function create(User $user, array $data): Chat;
    public function find(Chat $chat, array $relations = []): Chat;
}
