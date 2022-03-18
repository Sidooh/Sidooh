<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AirtimeRequest
 *
 * @property int $id
 * @property string $errorMessage
 * @property int $numSent
 * @property string $totalAmount
 * @property string $totalDiscount
 * @property int|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AirtimeResponse|null $response
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AirtimeResponse[] $responses
 * @property-read int|null $responses_count
 * @property-read \App\Models\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereNumSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereUpdatedAt($value)
 * @mixin IdeHelperAirtimeRequest
 */
class AirtimeRequest extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'errorMessage', 'numSent', 'totalAmount', 'totalDiscount'
    ];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function responses()
    {
        return $this->hasMany(AirtimeResponse::class);
    }

    public function response()
    {
        return $this->hasOne(AirtimeResponse::class);
    }

}
