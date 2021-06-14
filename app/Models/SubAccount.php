<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['balance'];

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

}
