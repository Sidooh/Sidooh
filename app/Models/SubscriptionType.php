<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscriptionType
 *
 * @property int $id
 * @property string $title
 * @property string $amount
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $level_limit
 * @property int $duration
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereLevelLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereUpdatedAt($value)
 * @mixin IdeHelperSubscriptionType
 */
class SubscriptionType extends Model
{
    //
}
