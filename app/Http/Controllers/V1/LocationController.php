<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BarangayResource;
use App\Http\Resources\V1\MunicipalityResource;
use App\Http\Resources\V1\ProvinceResource;
use App\Repositories\LocationRepository;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function __construct(
        private LocationRepository $locationRepository
    ){}

    public function getProvinces(): JsonResponse
    {
        return Response::success(
            ProvinceResource::collection($this->locationRepository->getProvinces()),
            'Provinces retrieved successfully.'
        );
    }

    public function getMunicipalities(?string $provinceCode = null): JsonResponse
    {
        return Response::success(
            MunicipalityResource::collection($this->locationRepository->getMunicipalities($provinceCode)),
            'Municipalities retrieved successfully.'
        );
    }

    public function getBarangays(?string $municipalityCode = null): JsonResponse
    {
        return Response::success(
            BarangayResource::collection($this->locationRepository->getBarangays($municipalityCode)),
            'Barangays retrieved successfully.'
        );
    }
}
