<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UssdLog
 *
 * @property int $id
 * @property string $phone
 * @property string $text
 * @property string $session_id
 * @property string $service_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereServiceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereUpdatedAt($value)
 * @mixin IdeHelperUssdLog
 */
class UssdLog extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['phone', 'text', 'session_id', 'service_code'];
}
