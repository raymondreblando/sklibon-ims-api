<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatParticipant;
use Illuminate\Database\Eloquent\Collection;

interface ChatParticipantRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(Chat $chat, array $data): Collection;
    public function findById(string $id): ?ChatParticipant;
    public function delete(ChatParticipant $chatParticipant): bool;
}
