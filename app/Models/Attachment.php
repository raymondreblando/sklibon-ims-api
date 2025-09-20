<?php

namespace App\Models;

use App\Policies\AttachmentPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(AttachmentPolicy::class)]
class Attachment extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'report_id',
        'attachment',
        'filename',
        'file_type',
        'file_size',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }
}
