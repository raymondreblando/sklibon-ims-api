<?php

namespace App\Repositories\Eloquent;

use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
use App\Repositories\LocationRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentLocationRepository implements LocationRepository
{
    public function getProvinces(): Collection
    {
        return Province::orderBy('name')->get(['id', 'name']);
    }

    public function getMunicipalities(?string $province): Collection
    {
        if (empty($province))
            return Municipality::orderBy('name')->get(['id', 'name']);

        $province = Province::find($province);
        return $province->municipalities()->orderBy('name')->get(['id', 'name']);
    }

    public function getBarangays(?string $municipality): Collection
    {
        if (empty($municipality))
            return Barangay::orderBy('name')->get(['id', 'name']);

        $municipality = Municipality::find($municipality);
        return $municipality->barangays()->orderBy('name')->get(['id', 'name']);
    }
}
