<?php

namespace App\Repositories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;

interface ReportRepository
{
    public function get(array $criteria = [], array $relations = []): Collection;
    public function create(array $data): Report;
    public function find(Report $report): ?Report;
    public function update(Report $report, array $data): ?Report;
    public function delete(Report $report): bool;
}
