<?php

namespace App\Models;

use App\Policies\ArchivePolicy;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(ArchivePolicy::class)]
class Archive extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'archivable_id',
        'archivable_type',
        'archived_by'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function archivable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'archived_by', 'id');
    }

    public function scopeWithArchivable(Builder $query): Builder
    {
        return $query->with(['archivable' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Event::class => [
                    'user:id,profile',
                    'user.userInfo:id,user_id,position_id,firstname,lastname',
                    'user.userInfo.position:id,name',
                    'barangay:id,name'
                ],
                Report::class => [
                    'barangay:id,name',
                    'user:id,profile',
                    'user.userInfo:id,user_id,position_id,firstname,lastname',
                    'user.userInfo.position:id,name',
                    'attachments:id,report_id,attachment'
                ],
            ]);
        }]);
    }
}
