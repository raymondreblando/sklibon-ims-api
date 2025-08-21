<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentContactRepository implements ContactRepository
{
    protected array $relations = [
        'user',
        'user.userInfo',
        'user.userInfo.position:id,name',
        'user.userInfo.province:id,name',
        'user.userInfo.municipality:id,name',
        'user.userInfo.barangay:id,name',
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

    public function find(Contact $contact, array $relations = []): Contact
    {
        return $contact->load($relations ?: $this->relations);
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function delete(Contact $contact): bool
    {
        return $contact->delete();
    }
}
