<?php

namespace App\Models;

use App\Policies\EventPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(EventPolicy::class)]
class Event extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'barangay_id',
        'name',
        'description',
        'event_date',
        'expired_date',
        'open_attendance',
        'image_url',
        'venue',
        'status',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'expired_date' => 'datetime',
        'open_attendance' => 'bool',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'event_id', 'id');
    }
}
