<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Models\User;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentEventRepository implements EventRepository
{
    protected array $relations = [];

    public function get(): Collection
    {
        return Event::all()->sortByDesc("primary");
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
