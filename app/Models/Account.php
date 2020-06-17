<?php

namespace App\Model;

use App\Models\Subscription;
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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function active_subscription()
    {
        return $this->hasMany(Subscription::class)->active();
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

}
