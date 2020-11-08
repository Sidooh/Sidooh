<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    //

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getBalanceAttribute()
    {
        return $this->in - $this->out;
    }

}
