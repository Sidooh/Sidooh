<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Telco extends Model
{
    //
    protected $fillable = [
        'initials', 'Name', 'active'
    ];
}
