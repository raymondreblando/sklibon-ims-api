<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface EventRepository
{
    public function get(): Collection;
    public function create(User $user, array $data): Event;
    public function find(Event $event): ?Event;
    public function update(Event $event, array $data): ?Event;
    public function delete(Event $event): bool;
}
