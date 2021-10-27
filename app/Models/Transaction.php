<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nabcellent\Kyanda\Models\KyandaRequest;

class Transaction extends Model
{
    //

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

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

    public function kyandaTransaction()
    {
        return $this->hasOne(KyandaRequest::class, 'relation_id');
    }
}
