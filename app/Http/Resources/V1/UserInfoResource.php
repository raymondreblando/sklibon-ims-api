<?php

namespace App\Http\Resources\V1;

use App\Traits\Resource\MapFields;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    use MapFields;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'firstname' => $this->resource->firstname,
            'middlename' => $this->resource->middlename,
            'lastname' => $this->resource->lastname,
            'gender' => $this->resource->gender,
            'age' => $this->resource->age,
            'phoneNumber' => $this->resource->phone_number,
            'birthdate' => $this->resource->birthdate,
            'additionalAddress' => $this->resource->addtional_address,
            'position' => $this->whenLoaded('position', fn () => $this->mapFields($this->resource->position)),
            'province' => new ProvinceResource($this->whenLoaded('province')),
            'municipality' => new MunicipalityResource($this->whenLoaded('municipality')),
            'barangay' => new BarangayResource($this->whenLoaded('barangay'))
        ];
    }
}
