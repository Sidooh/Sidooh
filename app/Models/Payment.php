<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Samerior\MobileMoney\Mpesa\Database\Entities\MpesaStkRequest;

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

    public function payable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function descriptor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MpesaStkRequest::class, 'id', 'payment_id');
    }
}
