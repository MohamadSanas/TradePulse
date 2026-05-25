<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapitalAmount extends Model
{
    protected $table = 'capital_amount';

    protected $fillable = [
        'user_id',
        'capital',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}