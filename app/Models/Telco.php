<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Telco
 *
 * @property int $id
 * @property string $initials
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Telco newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Telco newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Telco query()
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereUpdatedAt($value)
 * @mixin IdeHelperTelco
 */
class Telco extends Model
{
    //
    protected $fillable = [
        'initials', 'name', 'active'
    ];
}
