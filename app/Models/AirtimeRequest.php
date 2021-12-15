<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
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
