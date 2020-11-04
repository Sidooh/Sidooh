<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telco extends Model
{
    //
    protected $fillable = [
        'initials', 'name', 'active'
    ];
}
