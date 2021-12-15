<?php

namespace App\Models;

use DrH\Mpesa\Database\Entities\MpesaBulkPaymentRequest;
use DrH\Mpesa\Database\Entities\MpesaStkRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
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
