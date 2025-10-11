<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ChatRepository
{
    public function get(array $criteria = []): Collection;
    public function create(User $user, array $data): Chat;
    public function find(Chat $chat, array $criteria = []): Chat;
    public function findById(string $id): ?Chat;
    public function update(Chat $chat, array $data): Chat;
}
