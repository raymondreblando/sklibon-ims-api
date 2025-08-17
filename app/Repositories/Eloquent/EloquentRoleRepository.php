<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\RoleRepository;

class EloquentRoleRepository implements RoleRepository
{
    public function findByRole(string $role): ?string
    {
        return Role::where('role', $role)->value('id');
    }
}
