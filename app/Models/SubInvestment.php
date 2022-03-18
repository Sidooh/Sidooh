<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubInvestment
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $collective_investment_id
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\CollectiveInvestment $collectiveInvestment
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereCollectiveInvestmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereUpdatedAt($value)
 * @mixin IdeHelperSubInvestment
 */
class SubInvestment extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'interest', 'account_id', 'collective_investment_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function collectiveInvestment()
    {
        return $this->belongsTo(CollectiveInvestment::class);
    }
}
