<?php


namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
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
