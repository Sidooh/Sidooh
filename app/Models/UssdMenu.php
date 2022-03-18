<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UssdMenu
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $is_parent
 * @property string $confirmation_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereConfirmationMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereIsParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereUpdatedAt($value)
 * @mixin IdeHelperUssdMenu
 */
class UssdMenu extends Model
{
    //
    protected $fillable = ['title', 'type', 'is_parent', 'confirmation_message'];
}
