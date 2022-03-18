<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Referral
 *
 * @property int $id
 * @property int $referee_phone
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $referee_id
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Account $referrer
 * @method static Builder|Referral active()
 * @method static Builder|Referral expired()
 * @method static Builder|Referral newModelQuery()
 * @method static Builder|Referral newQuery()
 * @method static Builder|Referral pending()
 * @method static Builder|Referral query()
 * @method static Builder|Referral timeActive()
 * @method static Builder|Referral whereAccountId($value)
 * @method static Builder|Referral whereCreatedAt($value)
 * @method static Builder|Referral whereId($value)
 * @method static Builder|Referral whereRefereeId($value)
 * @method static Builder|Referral whereRefereePhone($value)
 * @method static Builder|Referral whereStatus($value)
 * @method static Builder|Referral whereUpdatedAt($value)
 * @mixin IdeHelperReferral
 */
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
