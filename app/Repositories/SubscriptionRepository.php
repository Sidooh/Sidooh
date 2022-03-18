<?php


namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
 * App\Repositories\SubscriptionRepository
 *
 * @property int $id
 * @property float $amount
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $subscription_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereSubscriptionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereUpdatedAt($value)
 * @mixin IdeHelperSubscriptionRepository
 */
class SubscriptionRepository extends Model
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = app(Subscription::class);
    }

}
