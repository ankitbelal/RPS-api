<?php

namespace App\Models\auth;

use Illuminate\Database\Eloquent\Model;

class UserLoginActivity extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_type',
        'login_time',
        'logout_time',
        'action'
    ];
}
