<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Repositories\ChatParticipantRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentChatParticipantRepository implements ChatParticipantRepository
{
    public function create(Chat $chat, array $data): Collection
    {
        return $chat->chatParticipants()->createMany($data);
    }

    public function find(array $criteria = []): bool
    {
        $query = ChatParticipant::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        // return $query->
    }
}
