<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class, 'province_id', 'id');
    }
}
