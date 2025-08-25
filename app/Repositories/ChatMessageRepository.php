<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatMessage;

interface ChatMessageRepository
{
    public function create(Chat $chat, array $data): ChatMessage;
}
