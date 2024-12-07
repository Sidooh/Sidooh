<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'in', 'out'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getBalanceAttribute()
    {
        return $this->in - $this->out;
    }
}
