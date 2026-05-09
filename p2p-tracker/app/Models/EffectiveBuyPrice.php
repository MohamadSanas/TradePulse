<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EffectiveBuyPrice extends Model
{
    protected $fillable = [
        'user_id',
        'average_buy_price',
        'remaining_usdt',
        'remaining_lkr',
        'break_even_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAverageBuyPriceAttribute()
    {
        return $this->attributes['Average_Buy_Price'] ?? null;
    }

    public function setAverageBuyPriceAttribute($value)
    {
        $this->attributes['Average_Buy_Price'] = $value;
    }

    public function getBreakEvenPriceAttribute()
    {
        return $this->attributes['Breakeven_Price'] ?? null;
    }

    public function setBreakEvenPriceAttribute($value)
    {
        $this->attributes['Breakeven_Price'] = $value;
    }
}
