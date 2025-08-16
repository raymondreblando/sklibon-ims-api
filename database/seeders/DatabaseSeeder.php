<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            RoleEnum::SuperAdmin->value,
            RoleEnum::Admin->value,
            RoleEnum::User->value,
        ];

        foreach ($roles as $role) {
            Role::create(['role' => $role]);
        }

        $superAdminRole = Role::where('role', RoleEnum::SuperAdmin->value)->value('id');

        User::create([
            'role_id' => $superAdminRole,
            'username' => 'sksuperadmin',
            'email' => 'sksuperadmin@gmail.com',
            'password' => env('SUPERADMIN_PASS')
        ]);
    }
}
