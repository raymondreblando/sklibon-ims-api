<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
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
        return $this->hasMany(Municipality::class, 'province_code', 'code');
    }
}
