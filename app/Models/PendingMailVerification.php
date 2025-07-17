<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingMailVerification extends Model
{
    protected $fillable = [
        'email',
        'verification_code',
        'expires_at',
    ];
}
