<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MunicipalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalityResponse = Http::get('https://psgc.gitlab.io/api/regions/050000000/municipalities');

        if (! $municipalityResponse->ok())
            $this->command->error('Error fetching municipalities');

        $cityResponse = Http::get('https://psgc.gitlab.io/api/regions/050000000/cities');

        if (! $cityResponse->ok())
            $this->command->error('Error fetching cities');

        DB::beginTransaction();

        try {
            $municipalities = $municipalityResponse->json();

            foreach ($municipalities as $municipality) {
                Municipality::updateOrCreate(
                    ['code' => $municipality['code']],
                    [
                        'name' => $municipality['name'],
                        'province_code' => $municipality['provinceCode'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            $cities = $cityResponse->json();

            foreach ($cities as $city) {
                Municipality::updateOrCreate(
                    ['code' => $city['code']],
                    [
                        'name' => $city['name'],
                        'province_code' => $city['provinceCode'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding municipalities: ' . $e->getMessage());
        }
    }
}
