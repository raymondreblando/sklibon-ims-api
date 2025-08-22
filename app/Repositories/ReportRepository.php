<?php

namespace App\Repositories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ReportRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(User $user, array $data): Report;
    public function find(Report $report, array $relations = []): ?Report;
    public function update(Report $report, array $data): ?Report;
    public function delete(Report $report): bool;
}
