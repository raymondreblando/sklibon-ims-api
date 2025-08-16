<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Provinces;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $roles = [
                RoleEnum::SuperAdmin->value,
                RoleEnum::Admin->value,
                RoleEnum::User->value,
            ];

            foreach ($roles as $role) {
                Role::create(['role' => $role]);
            }

            $superAdminRole = Role::where('role', RoleEnum::SuperAdmin->value)->value('id');

            $user = User::create([
                'role_id' => $superAdminRole,
                'username' => 'sksuperadmin',
                'email' => 'sksuperadmin@gmail.com',
                'password' => env('SUPERADMIN_PASS')
            ]);

            $provinceCode = Province::where('name', 'Albay')->value('code');
            $municipalityCode = Municipality::where('name', 'Libon')->value('code');
            $barangayCode = Barangay::where('name', 'Bonbon')->value('code');

            $user->userInfo()->create([
                'firstname' => 'Sheila Mae',
                'lastname' => 'Vasquez',
                'gender' => 'Female',
                'age' => 23,
                'phone_number' => '09123456789',
                'birthdate' => '2004-01-12',
                'province_code' => $provinceCode,
                'municipality_code' => $municipalityCode,
                'barangay_code' => $barangayCode,
                'addtional_address' => '123 Main St, City',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding roles: ' . $e->getMessage());
        }
    }
}
