<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EffectiveBuyPrice extends Model
{
    protected $fillable = [
        'user_id',
        'Average_Buy_Price',
        'remaining_usdt',
        'remaining_lkr',
        'Breakeven_Price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAverageBuyPriceAttribute()
    {
        return $this->attributes['Average_Buy_Price'] ?? null;
    }

    public function getBreakEvenPriceAttribute()
    {
        return $this->attributes['Breakeven_Price'] ?? null;
    }
}
