<?php

namespace App\Listeners;

use App\Events\SubscriptionPurchaseEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Log;
use NumberFormatter;

class SubscriptionPurchaseSuccess
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SubscriptionPurchaseEvent $event
     * @return void
     */
    public function handle(SubscriptionPurchaseEvent $event)
    {
        //
//        TODO:: Send sms notification

        Log::info('----------------- Subscription Purchase Success');

        $type = $event->subscription->subscription_type;
        $account = $event->subscription->account;

        $phone = ltrim($account->phone, '+');

        $date = $event->subscription->created_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));
        $end_date = $event->subscription->created_at->addMonths($event->subscription->subscription_type->duration)->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $nf = new NumberFormatter('en', NumberFormatter::ORDINAL);
        $limit = $nf->format($type->level_limit);

//        $type->title = "Sidooh Agent";

        switch ($type->duration) {
            case 1:
                $message = "Congratulations! You have successfully registered as a {$type->title} on {$date}, valid until {$end_date}. ";
                $message .= "You will earn commissions on every airtime purchased by your referred customers and subagents up to your {$limit} ripple.\n";

                break;

            default:

                $level_duration = $type->duration . " MONTHS";
                $message = "Congratulations! You have successfully preregistered as a {$type->title} on {$date}, valid until {$end_date}. ";
                $message .= "You will earn commissions on every airtime purchased by your referred customers and subagents up to your ";
                $message .= "{$limit} ripple, for {$level_duration} WITHOUT PAYING MONTHLY SUBSCRIPTION FEES.\n";

        }

        $message .= config('services.sidooh.tagline');

        NotificationRepository::sendSMS([$phone], $message);
    }
}
