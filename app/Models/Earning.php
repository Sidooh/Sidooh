<?php

namespace App\Models;

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

    public function transactedAccount()
    {
        return $this->hasOneThrough(Account::class, Transaction::class, 'account_id', 'id', 'transaction_id', 'id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Account::class);
//        TODO: Test using select as well for data minimisation/optimisation
//            ->select(['user_id', 'email', 'name']);
    }
}
