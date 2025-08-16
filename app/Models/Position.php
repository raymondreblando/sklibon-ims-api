<?php

namespace App\Models;

use App\Policies\PositionPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(PositionPolicy::class)]
class Position extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function userInfos(): HasMany
    {
        return $this->hasMany(UserInfo::class, 'position_id', 'id');
    }
}
