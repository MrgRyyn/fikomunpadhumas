<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = 'otps';

    protected $fillable = [
        'email',
        'email_hash',
        'session_id',
        'otp',
        'expires_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'expires_at' => 'datetime',
        'last_resend' => 'datetime',
    ];

}
