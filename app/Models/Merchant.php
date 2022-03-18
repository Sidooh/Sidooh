<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Merchant
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $contact_name
 * @property string $contact_number
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property-read \App\Models\Account $account
 * @property-read mixed $balance
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereUpdatedAt($value)
 * @mixin IdeHelperMerchant
 */
class Merchant extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'contact_number', 'contact_name', 'in', 'out', 'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getBalanceAttribute()
    {
        return $this->in - $this->out;
    }

}
