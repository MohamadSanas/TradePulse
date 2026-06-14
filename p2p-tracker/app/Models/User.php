<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Trade;
use App\Models\EffectiveBuyPrice;
use App\Models\CurrentProfite;
use App\Models\CapitalAmount;
use App\Models\WithdrawHistory;

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

    public function currentprofite(): HasMany
    {
        return $this->hasMany(CurrentProfite::class);
    }

    public function capital_amount(): HasMany
    {
        return $this->hasMany(CapitalAmount::class);
    }

    public function withdrawHistories()
    {
        return $this->hasMany(WithdrawHistory::class);
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
