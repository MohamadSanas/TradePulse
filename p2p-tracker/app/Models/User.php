<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Trade;
use App\Models\EffectiveBuyPrice;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }

    public function effective_buy_prices(): HasMany
    {
        return $this->hasMany(EffectiveBuyPrice::class);
    }

    protected static function booted()
    {
        static::creating(function ($user) {

            $user->user_code = strtoupper(
                substr(md5(uniqid()), 0, 6)
            );

        });
    }
}
