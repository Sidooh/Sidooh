<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referee_phone', 'account_id',
//       'password',
    ];

    /**
     * Scope a query to only include pending referrals.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeTimeActive($query)
    {
        return $query->where('created_at', '>', Carbon::now()->subHours(48));
    }

    /**
     * Scope a query to only include pending referrals.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePending($query)
    {
        return $query->whereStatus('pending')->timeActive($query);
    }

    /**
     * Scope a query to only include active referrals.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->whereStatus('active');
    }

    /**
     * Scope a query to only include expired referrals.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeExpired($query)
    {
        return $query->whereStatus('pending')->where('created_at', '<', Carbon::now()->subHours(48));
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'referee_id');
    }

    public function referrer()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
