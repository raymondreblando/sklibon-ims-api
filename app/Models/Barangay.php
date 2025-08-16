<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = [
        'code',
        'name',
        'municipality_code',
        'province_code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
