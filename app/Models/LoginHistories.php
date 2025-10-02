<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LoginHistories extends Model
{
    protected $fillable = ['user_id', 'login_time', 'logout_time'];

    // Automatically cast the datetime fields to Carbon instances
    protected $casts = [
        'login_time' => 'datetime',
        'logout_time' => 'datetime',
    ];
}
