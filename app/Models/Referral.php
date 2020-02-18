<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referee_phone',
//        'email', 'password',
    ];
}
