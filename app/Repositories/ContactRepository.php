<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;

interface ContactRepository
{
    public function get(array $relations = []): Collection;
    public function create(array $data): Contact;
    public function find(Contact $contact, array $relations = []): Contact;
    public function update(Contact $contact, array $data): Contact;
    public function delete(Contact $contact): bool;
}
