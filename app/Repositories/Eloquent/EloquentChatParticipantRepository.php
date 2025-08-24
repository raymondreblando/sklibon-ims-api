<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Repositories\ChatParticipantRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentChatParticipantRepository implements ChatParticipantRepository
{
    protected array $relations = [
        'user:id,profile',
        'user.userInfo:id,user_id,position_id,firstname,lastname',
        'user.userInfo.position:id,name'
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        $query = ChatParticipant::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->with($relations ?: $this->relations)
            ->get();
    }

    public function create(Chat $chat, array $data): Collection
    {
        return $chat->chatParticipants()->createMany($data);
    }
}
