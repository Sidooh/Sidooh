<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityAccount extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'utility_number', 'provider'
    ];
}
