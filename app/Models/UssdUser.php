<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UssdUser extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['difficulty_level', 'name', 'office_id', 'phone', 'email', 'session', 'progress', 'confirm_from', 'menu_item_id'];

}
