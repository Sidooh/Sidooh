<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * @mixin IdeHelperAccount
 */
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isRoot()
    {
        return $this->referrer_id == null;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function sub_accounts()
    {
        return $this->hasMany(SubAccount::class);
    }

    public function current_account()
    {
        return $this->hasOne(SubAccount::class)->type('CURRENT');
    }

    public function savings_account()
    {
        return $this->hasOne(SubAccount::class)->type('SAVINGS');
    }

    public function interest_account()
    {
        return $this->hasOne(SubAccount::class)->type('INTEREST');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function voucher()
    {
        return $this->hasOne(Voucher::class);
    }

    public function active_subscription()
    {
//        TODO: Has One does not work here???
        return $this->hasOne(Subscription::class)->active();
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function pending_referrals()
    {
        return $this->hasMany(Referral::class)->pending();
    }

    public function active_referrals()
    {
        return $this->hasMany(Referral::class)->active();
    }

    public function referrer()
    {
        return $this->belongsTo(Account::class, 'referrer_id');
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    /**
     * Scope a query to only include active subscriptions.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSubscribed($query)
    {
        return $query->whereHas('active_subscription');
    }

    /**
     * Scope a query to only include active subscriptions for respective level.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSubscribedLevel($query, $level)
    {
        return $query->whereHas('active_subscription', function ($q) use ($level) {
            $q->whereHas('subscription_type', function ($q) use ($level) {
                $q->where('level_limit', '<=', $level);
            });
        })->whereDepth('>=', -$level);
    }

    /**
     * Scope a query to only include account with balance in sub accounts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function subAccountBalance($query)
    {
        return $query->whereHas('active_subscription');
    }

}
