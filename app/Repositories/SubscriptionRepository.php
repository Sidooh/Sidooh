<?php


namespace App\Repositories;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

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

    public function deactivate()
    {
        $activeSubscriptions = $this->active()->with('subscription_type')->get();

        foreach ($activeSubscriptions as $sub) {
            $endDate = $sub->created_at->addMonths($sub->subscription_type->duration);

            if ($endDate <= Carbon::today()) {
                $sub->active = false;
                $sub->save();
            }
        }

        return $activeSubscriptions;
    }

}
