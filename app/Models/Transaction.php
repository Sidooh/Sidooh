<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    public function payment()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
