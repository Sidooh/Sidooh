<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UssdMenu extends Model
{
    //
    protected $fillable = ['title', 'type', 'is_parent', 'confirmation_message'];
}
