<?php

namespace App\Repositories\Eloquent;

use App\Models\Request;
use App\Models\User;
use App\Repositories\RequestRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionSupport;

class EloquentRequestRepository implements RequestRepository
{
    protected array $relations = [
        'requester:id,profile',
        'requester.userInfo:id,user_id,position_id,firstname,lastname',
        'requester.userInfo.position:id,name',
        'requestType:id,name',
        'approver:id,profile',
        'approver.userInfo:id,user_id,position_id,firstname,lastname',
        'approver.userInfo.position:id,name',
        'disapprover:id,profile',
        'disapprover.userInfo:id,user_id,position_id,firstname,lastname',
        'disapprover.userInfo.position:id,name',
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        $query = Request::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->with($relations ?: $this->relations)
            ->withReceivable()
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getSummary(string $key, string $value, array $criteria = []): CollectionSupport
    {
        $query = Request::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->pluck($value, $key);
    }

    public function create(User $user, array $data): Request
    {
        return $user->requests()->create($data);
    }

    public function find(Request $request, array $relations = []): Request
    {
        $request->load($relations ?: $this->relations);
        return $request->loadReceivable();
    }

    public function update(Request $request, array $data): Request
    {
        $request->update($data);
        return $request;
    }

    public function delete(Request $request): bool
    {
        return $request->delete();
    }
}
