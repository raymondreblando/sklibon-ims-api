<?php

namespace App\Repositories\Eloquent;

use App\Enums\ReportStatus;
use App\Models\Report;
use App\Models\User;
use App\Repositories\ReportRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentReportRepository implements ReportRepository
{
    protected array $relations = [
        'barangay:id,name',
        'user:id,profile',
        'user.userInfo:id,user_id,position_id,firstname,lastname',
        'user.userInfo.position:id,name',
        'attachments'
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        $query = Report::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->with($relations ?: $this->relations)
            ->where('status', ReportStatus::Active->value)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(User $user, array $data): Report
    {
        return $user->reports()->create($data);
    }

    public function find(Report $report, array $relations = []): Report
    {
        return $report->load($relations ?: $this->relations);
    }

    public function findById(string $id): ?Report
    {
        return Report::findOrFail($id);
    }

    public function update(Report $report, array $data): Report
    {
        $report->update($data);
        return $report;
    }

    public function delete(Report $report): bool
    {
        return $report->delete();
    }
}
