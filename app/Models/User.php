<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['is_online'];
    protected $touches = ['chats'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->inChats()->attach(Chat::fetchPublicChatList());
        });
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function inChats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_users');
    }

    public function getIsOnlineAttribute(): bool
    {
        return !!DB::table('sessions')->whereUserId($this->id)
            ->first();
    }
}
