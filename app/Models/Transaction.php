<?php

namespace App\Models;

use DrH\Tanda\Models\TandaRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperTransaction
 */
class Transaction extends Model
{
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }

    public function airtime(): HasOne {
        return $this->hasOne(AirtimeRequest::class);
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function request(): HasOne
    {
        return $this->hasOne(TandaRequest::class, 'relation_id');
    }
}
