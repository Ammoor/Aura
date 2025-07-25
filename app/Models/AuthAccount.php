<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'provider',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
