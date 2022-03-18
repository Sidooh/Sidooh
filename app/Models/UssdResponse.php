<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UssdResponse
 *
 * @property int $id
 * @property int $user_id
 * @property int $menu_id
 * @property int $menu_item_id
 * @property string $response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereUserId($value)
 * @mixin IdeHelperUssdResponse
 */
class UssdResponse extends Model
{
    //
    protected $fillable = ['user_id', 'menu_id', 'response', 'menu_item_id'];
}
