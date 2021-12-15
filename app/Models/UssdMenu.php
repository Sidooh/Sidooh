<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUssdMenu
 */
class UssdMenu extends Model
{
    //
    protected $fillable = ['title', 'type', 'is_parent', 'confirmation_message'];
}
