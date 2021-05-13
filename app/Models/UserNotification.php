<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    //

    protected $fillable = [
        'type',
        'content',
        'to',
        'status'
    ];

    protected $casts = [
        'to' => 'array'
    ];
}
