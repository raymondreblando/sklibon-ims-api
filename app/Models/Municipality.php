<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = [
        'code',
        'name',
        'province_code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
