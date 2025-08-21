<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'request_type_id',
        'name',
        'description',
        'date_needed',
        'attachment',
        'receivable_id',
        'receivable_type',
        'status',
        'approved_date',
        'approved_by',
        'disapproved_date',
        'disapproved_by',
        'reason'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    public function receivable(): MorphTo
    {
        return $this->morphTo();
    }

    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class, 'request_type_id', 'id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function disapprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disapproved_by', 'id');
    }
}
