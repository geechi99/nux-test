<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Link extends Model
{
    protected $fillable = ['user_id', 'token', 'active', 'expires_at'];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public static function generateForUser($user)
    {
        return self::create([
            'user_id' => $user->id,
            'token' => Str::random(40),
            'active' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasMany(PlayResult::class);
    }

    public function isValid(): bool
    {
        if (!$this->active) {
            return false;
        }

        if (!$this->expires_at) {
            return false;
        }

        $expires = $this->expires_at instanceof Carbon ? $this->expires_at : Carbon::parse($this->expires_at);

        return $expires->isFuture();
    }
}
