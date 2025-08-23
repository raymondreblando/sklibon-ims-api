<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\User;
use App\Repositories\ChatRepository;

class EloquentChatRepository implements ChatRepository
{
    protected array $relations = [
        'chatPair.sender:id,profile',
        'chatPair.sender.userInfo:id,user_id,firstname,lastname',
        'chatPair.receiver:id,profile',
        'chatPair.receiver.userInfo:id,user_id,firstname,lastname',
    ];

    public function create(User $user, array $data): Chat
    {
        return $user->chats()->create($data);
    }

    public function find(Chat $chat, array $relations = []): Chat
    {
        return $chat->load($relations ?: $this->relations);
    }
}
