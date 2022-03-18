<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UssdUser
 *
 * @property int $id
 * @property string $phone
 * @property int $session
 * @property int $progress
 * @property int $pin
 * @property int $menu_id
 * @property int $confirm_from
 * @property int $menu_item_id
 * @property int $difficulty_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereConfirmFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereDifficultyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereUpdatedAt($value)
 * @mixin IdeHelperUssdUser
 */
class UssdUser extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['difficulty_level', 'name', 'office_id', 'phone', 'email', 'session', 'progress', 'confirm_from', 'menu_item_id'];

}
