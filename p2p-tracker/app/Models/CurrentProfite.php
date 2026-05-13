<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentProfite extends Model
{
    protected $table = 'currentprofite';

    protected $fillable = [
        'user_id',
        'profite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
