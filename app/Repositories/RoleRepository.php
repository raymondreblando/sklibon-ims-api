<?php

namespace App\Repositories;

interface RoleRepository
{
    public function findByRole(string $role): ?string;
}
