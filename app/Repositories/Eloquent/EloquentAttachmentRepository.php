<?php

namespace App\Repositories\Eloquent;

use App\Models\Attachment;
use App\Models\Report;
use App\Repositories\AttachmentRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentAttachmentRepository implements AttachmentRepository
{
    public function create(Report $report, array $data): Attachment
    {
        return $report->attachments()->create($data);
    }

    public function createMany(Report $report, array $data): Collection
    {
        return $report->attachments()->createMany($data);
    }

    public function delete(Attachment $attachment): bool
    {
        return $attachment->delete();
    }
}
