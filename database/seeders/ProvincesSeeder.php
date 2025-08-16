<?php

namespace Database\Seeders;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://psgc.gitlab.io/api/regions/050000000/provinces');

        if (! $response->ok())
            $this->command->error('Error fetching provinces');

        DB::beginTransaction();

        try {
            $provinces = $response->json();

            foreach ($provinces as $province) {
                Province::updateOrCreate(
                    ['code' => $province['code']],
                    [
                        'name' => $province['name'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding provinces: ' . $e->getMessage());
        }
    }
}
