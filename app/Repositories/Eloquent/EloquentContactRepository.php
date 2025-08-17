<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentContactRepository implements ContactRepository
{
    protected array $relations = [
        'user:id,username,email',
        'user.userInfo:user_id,firstname,middlename,lastname,phone_number,province_code,municipality_code,baragay_code',
        'user.userInfo.position:id,name',
        'user.userInfo.province:code,name',
        'user.userInfo.municipality:code,name',
        'user.userInfo.barangay:code,name',
    ];

    public function get(array $relations = []): Collection
    {
        return Contact::with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function delete(Contact $contact): bool
    {
        return $contact->delete();
    }
}
