<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatPair;

interface ChatPairRepository
{
    public function create(Chat $chat, array $data): ChatPair;
    public function findUserPair(string $senderId, string $receiverId): ?ChatPair;
}
