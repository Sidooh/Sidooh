<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperTransaction
 */
class Transaction extends Model
{

    public function getCreatedAtAttribute($value): bool|Carbon {

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $value, 'UTC');
        $date->setTimezone('Africa/Nairobi');

        return $date;
    }

    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }

    public function airtime(): HasOne {
        return $this->hasOne(AirtimeRequest::class);
    }

    public function payment(): MorphOne {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function payments(): MorphMany {
        return $this->morphMany(Payment::class, 'payable');
    }
}
