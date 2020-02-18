<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //


    public function payable()
    {
        return $this->morphTo();
    }
}
