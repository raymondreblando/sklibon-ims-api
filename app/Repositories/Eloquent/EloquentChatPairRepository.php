<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\ChatPair;
use App\Repositories\ChatPairRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EloquentChatPairRepository implements ChatPairRepository
{
    public function create(Chat $chat, array $data): ChatPair
    {
        return $chat->chatPair()->create($data);
    }

    public function findUserPair(string $senderId, string $receiverId): ?ChatPair
    {
        return ChatPair::where(function (Builder $query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)
                    ->where('receiver_id', $receiverId);
            })
            ->orWhere(function (Builder $query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $senderId);
            })->first();
    }
}
