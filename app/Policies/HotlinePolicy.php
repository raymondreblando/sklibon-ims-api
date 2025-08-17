<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Hotline;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HotlinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role->role, [
            Role::SuperAdmin->value,
            Role::Admin->value,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hotline $hotline): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hotline $hotline): bool
    {
        return $this->viewAny($user);
    }
}
