<?php

namespace App\Traits\Auth;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

trait HasAuthUser
{
    protected ?User $authUser = null;

    protected function user(): User|Authenticatable|null
    {
        if ($this->authUser) return $this->authUser;

        return $this->authUser = auth()->user();
    }

    protected function getAuthUserId(): ?string
    {
        return $this->user()?->id;
    }

    protected function getAuthUserName(): string
    {
        $userInfo = $this->user()->userInfo;
        return "{$userInfo->firstname} {$userInfo->lastname}";
    }

    protected function isAdmin(): bool
    {
        if (! $this->user()) return false;

        return in_array($this->user()->role->role, [
            Role::SuperAdmin->value,
            Role::Admin->value,
        ]);
    }

    protected function getAuthUserBarangay(): ?string
    {
        if (! $this->user() || ! $this->user()->userInfo) return null;

        return $this->user()->userInfo->barangay->id;
    }
}
