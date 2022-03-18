<?php

namespace App\Models;


use DrH\Mpesa\Entities\MpesaBulkPaymentRequest;
use DrH\Mpesa\Entities\MpesaStkRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $payable_id
 * @property string $payable_type
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string $subtype
 * @property int $payment_id
 * @property string $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_type
 * @property-read Model|\Eloquent $payable
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @mixin IdeHelperPayment
 */
class Payment extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'status', 'type', 'subtype', 'payment_id'
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_type'];


    public function getFullTypeAttribute($value): string
    {
        return "{$this->type} {$this->subtype}";
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function stkRequest(): HasOne
    {
        return $this->hasOne(MpesaStkRequest::class, 'id', 'payment_id');
    }

    public function b2cRequest(): HasOne
    {
        return $this->hasOne(MpesaBulkPaymentRequest::class, 'id', 'payment_id');
    }

}
