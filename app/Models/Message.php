<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['user_id', 'chat_id', 'body'];
    protected $appends = ['is_myself'];
    protected $touches = ['chat'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function getIsMyselfAttribute(): bool
    {
        return !auth()->check() ? false : $this->user_id === auth()->id();
    }
}
