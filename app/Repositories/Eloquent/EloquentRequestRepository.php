<?php

namespace App\Repositories\Eloquent;

use App\Models\Barangay;
use App\Models\Request;
use App\Models\User;
use App\Repositories\RequestRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EloquentRequestRepository implements RequestRepository
{
    protected array $relations = [
        'requestType:id,name',
        'receivable' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                User::class => ['id', 'firstname', 'lastname'],
                Barangay::class => ['id', 'name']
            ]);
        },
        'approver',
        'disapprover'
    ];

    public function get(array $relations = []): Collection
    {
        return Request::with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data): Request
    {
        return Request::create($data);
    }

    public function find(Request $request, array $relations = []): ?Request
    {
        return $request->load($relations ?: $this->relations);
    }

    public function update(Request $request, array $data): ?Request
    {
        $request->update($data);
        return $request;
    }

    public function delete(Request $request): bool
    {
        return $request->delete();
    }
}
