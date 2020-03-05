<?php

namespace App\Model;

use App\Models\AirtimeRequest;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    public function airtime()
    {
        return $this->hasOne(AirtimeRequest::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
