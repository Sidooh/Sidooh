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
     * Scope a query to only include specific sub account type.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeType($query, $type)
    {
        return $query->whereType($type);
    }

    public function balance()
    {
        return $this->in - $this->out;
    }

}
