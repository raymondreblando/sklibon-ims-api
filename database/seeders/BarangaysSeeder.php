<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
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

            $provinces = Province::pluck('id', 'code')->toArray();
            $municipalities = Municipality::pluck('id', 'code')->toArray();

            foreach ($barangays as $barangay) {
                Barangay::updateOrCreate(
                    ['code' => $barangay['code']],
                    [
                        'name' => $barangay['name'],
                        'municipality_id' => $municipalities[$barangay['municipalityCode'] ?: $barangay['cityCode']],
                        'province_id' => $provinces[$barangay['provinceCode']],
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
