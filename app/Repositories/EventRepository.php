<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface EventRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(User $user, array $data): Event;
    public function find(Event $event, array $relations = []): Event;
    public function update(Event $event, array $data): Event;
    public function delete(Event $event): bool;
}
