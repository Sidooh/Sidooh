<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Account extends Model
{
    //
    use HasRecursiveRelationships;

    public function getParentKeyName()
    {
        return 'referrer_id';
    }

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
