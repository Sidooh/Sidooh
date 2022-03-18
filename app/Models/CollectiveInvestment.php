<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CollectiveInvestment
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest_rate
 * @property string|null $interest
 * @property \Illuminate\Support\Carbon $investment_date
 * @property \Illuminate\Support\Carbon|null $maturity_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubInvestment[] $subInvestments
 * @property-read int|null $sub_investments_count
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereInvestmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereMaturityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereUpdatedAt($value)
 * @mixin IdeHelperCollectiveInvestment
 */
class CollectiveInvestment extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'interest_rate', 'interest', 'investment_date', 'maturity_date'
    ];

    protected $casts = [
        'investment_date' => 'date',
        'maturity_date' => 'date',
    ];


    public function subInvestments()
    {
        return $this->hasMany(SubInvestment::class);
    }
}
