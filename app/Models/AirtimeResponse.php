<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AirtimeResponse
 *
 * @property int $id
 * @property string $phoneNumber
 * @property string $errorMessage
 * @property string $amount
 * @property string $status
 * @property string $requestID
 * @property string $discount
 * @property int $airtime_request_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AirtimeRequest $request
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereAirtimeRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereRequestID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereUpdatedAt($value)
 * @mixin IdeHelperAirtimeResponse
 */
class AirtimeResponse extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phoneNumber', 'errorMessage', 'amount', 'status', 'requestId', 'discount'
    ];

    public function request()
    {
        return $this->belongsTo(AirtimeRequest::class, 'airtime_request_id');
    }

}
