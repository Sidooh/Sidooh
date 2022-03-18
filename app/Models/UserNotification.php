<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property string $type
 * @property string $content
 * @property array $to
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUpdatedAt($value)
 * @mixin IdeHelperUserNotification
 */
class UserNotification extends Model
{
    //

    protected $fillable = [
        'type',
        'content',
        'to',
        'status'
    ];

    protected $casts = [
        'to' => 'array'
    ];
}
