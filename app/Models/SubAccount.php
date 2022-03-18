<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubAccount
 *
 * @property int $id
 * @property string $type
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property-read \App\Models\Account $account
 * @property-read mixed $balance
 * @method static Builder|SubAccount newModelQuery()
 * @method static Builder|SubAccount newQuery()
 * @method static Builder|SubAccount query()
 * @method static Builder|SubAccount type($type)
 * @method static Builder|SubAccount whereAccountId($value)
 * @method static Builder|SubAccount whereCreatedAt($value)
 * @method static Builder|SubAccount whereId($value)
 * @method static Builder|SubAccount whereIn($value)
 * @method static Builder|SubAccount whereOut($value)
 * @method static Builder|SubAccount whereType($value)
 * @method static Builder|SubAccount whereUpdatedAt($value)
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
