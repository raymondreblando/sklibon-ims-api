<?php

namespace App\Models;

use App\Policies\ChatPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(ChatPolicy::class)]
class Chat extends Model
{
    use HasUlids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'created_by',
        'name',
        'type',
        'last_message',
        'last_message_at'
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function chatPair(): HasOne
    {
        return $this->hasOne(ChatPair::class, 'chat_id', 'id');
    }

    public function chatParticipants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class, 'chat_id', 'id');
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

    public function isParticipant(User $user): bool
    {
        return $this->chatParticipants()
            ->where('user_id', $user->id)
            ->exists();
    }
}
