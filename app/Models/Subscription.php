<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property float $amount
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $subscription_type_id
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\SubscriptionType $subscription_type
 * @method static Builder|Subscription active()
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereAccountId($value)
 * @method static Builder|Subscription whereActive($value)
 * @method static Builder|Subscription whereAmount($value)
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereSubscriptionTypeId($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
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
