<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawHistory extends Model
{
    protected $table = 'withdraw_history';

    protected $fillable = [
        'user_id',
        'amount',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
