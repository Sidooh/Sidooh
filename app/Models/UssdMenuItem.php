<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UssdMenuItem extends Model
{
    //
    protected $fillable = ['menu_id', 'description', 'type', 'next_menu_id', 'step', 'confirmation_phrase'];
}
