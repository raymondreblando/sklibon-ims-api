<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface LocationRepository
{
    public function getProvinces(): Collection;
    public function getMunicipalities(?string $province): Collection;
    public function getBarangays(?string $municipality): Collection;
}
