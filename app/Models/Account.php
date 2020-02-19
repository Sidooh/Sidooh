<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'telco_id', 'phone', 'referrer_id'
    ];

    public function pendingReferrals()
    {
        return $this->hasMany(Referral::class)->pending();
    }

    public function activeReferrals()
    {
        return $this->hasMany(Referral::class)->active();
    }

    public function referrer()
    {
        return $this->belongsTo(Account::class, 'referrer_id');
    }

}
