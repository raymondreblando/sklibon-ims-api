<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
