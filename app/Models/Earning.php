<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'earnings', 'account_id', 'transaction_id', 'aggregate_transactions', 'type'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
