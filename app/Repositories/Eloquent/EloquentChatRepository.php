<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\User;
use App\Repositories\ChatRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentChatRepository implements ChatRepository
{
    protected array $relations = [
        'chatPair.sender:id,profile',
        'chatPair.sender.userInfo:id,user_id,firstname,lastname',
        'chatPair.receiver:id,profile',
        'chatPair.receiver.userInfo:id,user_id,firstname,lastname',
    ];

    public function get(array $criteria = []): Collection
    {
        $query = Chat::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->orderBy('last_message_at', 'desc')
            ->get();
    }

    public function create(User $user, array $data): Chat
    {
        return $user->chats()->create($data);
    }

    public function find(array $criteria = []): Chat
    {
        $query = Chat::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->first();
    }

    public function findById(string $id): ?Chat
    {
        return Chat::findOrFail($id);
    }

    public function update(Chat $chat, array $data): Chat
    {
        $chat->update($data);
        return $chat;
    }
}
