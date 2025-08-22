<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Models\User;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentEventRepository implements EventRepository
{
    protected array $relations = [
        'user:id,profile',
        'user.userInfo:id,user_id,firstname,lastname',
        'barangay:id,name'
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        $query = Event::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(User $user, array $data): Event
    {
        return $user->events()->create($data);
    }

    public function find(Event $event): ?Event
    {
        return $event;
    }

    public function update(Event $event, array $data): ?Event
    {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): bool
    {
        return $event->delete();
    }
}
