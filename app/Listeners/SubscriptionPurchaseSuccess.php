<?php

namespace App\Listeners;

use App\Events\SubscriptionPurchaseEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use Illuminate\Support\Facades\Log;

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

        switch ($type->amount) {
            case 4975:
            case 9975:
                $level_duration = $type->amount == 9975 ? "24 MONTHS" : "18 MONTHS";
                $message = "Congratulations! You have successfully been pre-registered as a {$type->title} ";
                $message .= "on {$date}. ";
                $message .= "You will earn commissions on every airtime purchased by your referred customers ";
                $message .= "and sub agents UP TO LEVEL {$type->level_limit} FOR {$level_duration} WITHOUT PAYING THE MONTHLY FEES.\n\n";
                $message .= "Sidooh, Earns you money on every purchase";

                break;

            default:
                $message = "Congratulations! You have successfully subscribed for {$type->title} Services ";
                $message .= "at Ksh{$type->amount} on {$date}. ";
                $message .= "This unlocks your referral earnings potential. ";
                $message .= "You will earn commissions on every purchase by your referred customers ";
                $message .= "and sub agents up to level {$type->level_limit}.\n\n";
                $message .= "Sidooh, Earns you money on every purchase";
        }

        (new AfricasTalkingApi())->sms($phone, $message);
    }
}
