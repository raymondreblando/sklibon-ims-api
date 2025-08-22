<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;

interface AttachmentRepository
{
    public function create(Report $report, array $data): Collection;
    public function delete(Attachment $attachment): bool;
}
