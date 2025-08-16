<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BarangaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://psgc.gitlab.io/api/regions/050000000/barangays');

        if (! $response->ok())
            $this->command->error('Error fetching barangays');

        DB::beginTransaction();

        try {
            $barangays = $response->json();

            foreach ($barangays as $barangay) {
                Barangay::updateOrCreate(
                    ['code' => $barangay['code']],
                    [
                        'name' => $barangay['name'],
                        'municipality_code' => $barangay['municipalityCode'] ?: $barangay['cityCode'],
                        'province_code' => $barangay['provinceCode'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding barangays: ' . $e->getMessage());
        }
    }
}
