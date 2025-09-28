<?php

namespace App\Http\Resources\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'archivableType' => $this->resource->archivable_type,
            'archivableId' => $this->resource->archivable_id,
            'createdAt' => $this->resource->created_at,
            'archivable' => $this->whenLoaded('archivable', function () {
                $archivable = $this->resource->archivable;

                return $archivable instanceof Event
                    ? new EventResource($archivable)
                    : new ReportResource($archivable);
            }),
            'achivedBy' => new MinifyUserResource($this->whenLoaded('user')),
        ];
    }
}
