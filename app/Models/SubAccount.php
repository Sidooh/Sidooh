<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSubAccount
 */
class SubAccount extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'account_id',
    ];

    /**
     * Scope a query to only include specific sub account type.
     *
     * @param Builder $query
     * @param $type
     * @return Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getBalanceAttribute()
    {
        return $this->in - $this->out;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
