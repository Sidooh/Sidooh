<?php


namespace App\Repositories;

use App\Events\ReferralJoinedEvent;
use App\Helpers\Sidooh\Report;
use App\Models\UserNotification;
use App\Models\CollectiveInvestment;
use App\Models\Referral;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\PhoneNumber;

class UserNotificationRepository
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
        $this->model = app(UserNotification::class);
    }

}
