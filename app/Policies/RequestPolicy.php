<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Request $request): bool
    {
        return $request->requester()->is($user)
            || ($request->receivable_id === $user->id || $request->receivable_id === $user->userInfo->barangay_id)
            || in_array($user->role->role, [
                Role::SuperAdmin->value,
                Role::Admin->value
            ]);
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
    public function update(User $user, Request $request): bool
    {
        return $this->view($user, $request);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Request $request): bool
    {
        return $this->update($user, $request);
    }
}
