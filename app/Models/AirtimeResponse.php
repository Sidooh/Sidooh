<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
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
