<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Barangay extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'province_id',
        'municipality_id',
        'code',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'code');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function requests(): MorphMany
    {
        return $this->morphMany(Request::class, 'receivable');
    }
}
