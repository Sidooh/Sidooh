<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Earning
 *
 * @property int $id
 * @property string|null $aggregate_transactions
 * @property string $earnings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $account_id
 * @property int $transaction_id
 * @property string $type
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Earning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning query()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereAggregateTransactions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereUpdatedAt($value)
 * @mixin IdeHelperEarning
 */
class Earning extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'earnings', 'account_id', 'transaction_id', 'aggregate_transactions', 'type'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
