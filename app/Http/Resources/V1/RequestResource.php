<?php

namespace App\Http\Resources\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'dateNeeded' => $this->resource->date_needed,
            'attachment' => $this->resource->attachment,
            'status' => $this->resource->status,
            'approvedDate' => $this->resource->approved_date,
            'disapprovedDate' => $this->resource->disapproved_date,
            'filedDate' => $this->resource->created_at,
            'reason' => $this->resource->reason,
            'type' => new RequestTypeResource($this->whenLoaded('requestType')),
            'receiver' => $this->whenLoaded('receivable', function () {
                return $this->resource->receivable instanceof User
                    ? new MinifyUserResource($this->resource->receivable)
                    : new BarangayResource($this->resource->receivable);
            }),
            'requester' => new MinifyUserResource($this->whenLoaded('requester')),
            'approver' => new MinifyUserResource($this->whenLoaded('approver')),
            'disapprover' => new MinifyUserResource($this->whenLoaded('disapprover')),
        ];
    }
}
