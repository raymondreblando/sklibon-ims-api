<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Hotline extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'abbreviation',
        'hotline',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
