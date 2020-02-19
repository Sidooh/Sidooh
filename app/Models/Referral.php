<?php

namespace App\Model;

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
        'referee_phone',
//        'email', 'password',
    ];

    /**
     * Scope a query to only include pending referrals.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeTimeActive($query)
    {
        return $query->where('created_at', '>', Carbon::now()->subHours(24));
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

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
