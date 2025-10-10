<?php

namespace App\Models;

use App\Policies\ReportPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(ReportPolicy::class)]
class Report extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'barangay_id',
        'user_id',
        'subject',
        'description',
        'status'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'report_id', 'id');
    }

    public function archives(): MorphMany
    {
        return $this->morphMany(Archive::class, 'archivable');
    }
}
