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
        return Province::orderBy('name')->get(['code', 'name']);
    }

    public function getMunicipalities(?string $province): Collection
    {
        $query = Municipality::query();

        if (! empty($province)) $query->where('province_code', $province);

        return $query->orderBy('name')->get(['code', 'name']);
    }

    public function getBarangays(?string $municipality): Collection
    {
        $query = Barangay::query();

        if (! empty($municipality)) $query->where('municipality_code', $municipality);

        return $query->orderBy('name')->get(['code', 'name']);
    }
}
