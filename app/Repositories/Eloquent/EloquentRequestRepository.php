<?php

namespace App\Repositories\Eloquent;

use App\Models\Barangay;
use App\Models\Request;
use App\Models\User;
use App\Repositories\RequestRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentRequestRepository implements RequestRepository
{
    protected array $relations = [
        'requester.userInfo:id,user_id,firstname,lastname',
        'requestType:id,name',
        'approver.userInfo:id,user_id,firstname,lastname',
        'disapprover.userInfo:id,user_id,firstname,lastname'
    ];

    public function get(array $relations = []): Collection
    {
        return Request::with($relations ?: $this->relations)
            ->withReceivable()
            ->orderBy('id', 'desc')
            ->get();
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
