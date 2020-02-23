<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UssdResponse extends Model
{
    //
    protected $fillable = ['user_id', 'menu_id', 'response', 'menu_item_id'];
}
