<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'type',
        'amount_usdt',
        'bank_fee',
        'total_lkr',
        'fee'
    ];
}































