<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTransaction
 */
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
}
