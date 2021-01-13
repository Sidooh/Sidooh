<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function subInvestments()
    {
        return $this->hasMany(SubInvestment::class);
    }
}
