<?php

namespace App\Models;

use App\Model\Account;
use App\Model\SubscriptionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
//        'account_id', 'subscription_type_id'
    ];

    /**
     * Scope a query to only include active subscriptions.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->whereActive(true);
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
