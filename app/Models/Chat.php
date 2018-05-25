<?php

namespace App\Models;

use App\Core\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Chat extends Model
{
    protected $fillable = ['user_id', 'type'];
    protected $appends = ['is_myself'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if ($model->type === Constants::CHAT_TYPE_PRIVATE) {
                $model->users()->attach($model->user_id);
                return;
            }

            $model->users()->attach(User::all());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_users');
    }

    public static function fetchChatList(): Collection
    {
        return self::orderBy('updated_at')->get();
    }

    public static function fetchPublicChatList(): Collection
    {
        return self::whereType(Constants::CHAT_TYPE_PUBLIC)->get();
    }

    public function getIsMyselfAttribute(): bool
    {
        return !auth()->check() ? false : $this->user_id === auth()->id();
    }
}
