<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
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
