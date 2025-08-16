<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'position_id',
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'age',
        'phone_number',
        'birthdate',
        'province_code',
        'municipality_code',
        'barangay_code',
        'addtional_address',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return ['birthdate' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
