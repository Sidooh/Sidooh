<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSubscription
 */
class Subscription extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'active',
        'account_id', 'subscription_type_id'
    ];

    /**
     * Scope a query to only include active subscriptions.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->latest()->whereActive(true);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subscription_type()
    {
        return $this->belongsTo(SubscriptionType::class);
    }
}
