<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;
use App\Repositories\ReportRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentReportRepository implements ReportRepository
{
    protected array $relations = [
        'barangay:id,name',
        'user.userInfo:id,user_id,firstname,lastname',
        'attachments:id,report_id,attachment'
    ];

    public function get(array $criteria = [], array $relations = []): Collection
    {
        $query = Report::query();

        foreach ($criteria as $criterion) {
            $criterion->apply($query);
        }

        return $query->with($relations ?: $this->relations)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data): Report
    {
        return Report::create($data);
    }

    public function find(Report $report): ?Report
    {
        return $report;
    }

    public function update(Report $report, array $data): ?Report
    {
        $report->update($data);
        return $report;
    }

    public function delete(Report $report): bool
    {
        return $report->delete();
    }
}
