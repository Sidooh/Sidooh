<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTelco
 */
class Telco extends Model
{
    //
    protected $fillable = [
        'initials', 'name', 'active'
    ];
}
