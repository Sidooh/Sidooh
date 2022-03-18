<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UssdMenuItem
 *
 * @property int $id
 * @property int $menu_id
 * @property string $description
 * @property int $type
 * @property int $next_menu_id
 * @property int $step
 * @property string $confirmation_phrase
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereConfirmationPhrase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereNextMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereUpdatedAt($value)
 * @mixin IdeHelperUssdMenuItem
 */
class UssdMenuItem extends Model
{
    //
    protected $fillable = ['menu_id', 'description', 'type', 'next_menu_id', 'step', 'confirmation_phrase'];
}
