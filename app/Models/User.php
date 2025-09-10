<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role as RoleEnum;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[UsePolicy(UserPolicy::class)]
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, HasUlids, Notifiable, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'username',
        'email',
        'password',
        'status',
        'profile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function fullname(): Attribute
    {
        return Attribute::get(function () {
            return $this->userInfo
                ? "{$this->userInfo->firstname} {$this->userInfo->lastname}"
                : null;
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function userInfo(): HasOne
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function refreshTokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class, 'user_id', 'id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'user_id', 'id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'user_id', 'id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'user_id', 'id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class, 'user_id', 'id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'created_by', 'id');
    }

    public function receivables(): MorphMany
    {
        return $this->morphMany(Request::class, 'receivable');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function isAdmin(): bool
    {
        return in_array($this->role->role, [
            RoleEnum::SuperAdmin->value,
            RoleEnum::Admin->value,
        ]);
    }
}
