<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoom extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'type',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    public function sendMessage(User $user, string $message, string $type = 'text', array $metadata = null): ChatMessage
    {
        return $this->messages()->create([
            'user_id' => $user->id,
            'message' => $message,
            'type' => $type,
            'metadata' => $metadata,
        ]);
    }
} 