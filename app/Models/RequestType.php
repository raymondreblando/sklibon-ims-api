<?php

namespace App\Models;

use App\Policies\RequestTypePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(RequestTypePolicy::class)]
class RequestType extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'status'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];
}
