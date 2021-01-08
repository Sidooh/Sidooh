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
        $end_date = $event->subscription->created_at->addMonths($event->subscription->subscription_type->duration)->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));


        switch ($type->amount) {
            case 4975:
            case 9975:
                $level_duration = $type->amount == 9975 ? "24 MONTHS" : "18 MONTHS";
                $message = "Congratulations! You have successfully preregistered as a {$type->title} on {$date}, valid until {$end_date}. ";
                $message .= "You will earn commissions on every airtime purchased by your referred customers and subagents up to your ";
                $message .= "{$type->level_limit}, for {$level_duration} WITHOUT PAYING MONTHLY SUBSCRIPTION FEES. ";
                $message .= "Please note, 80% of your commissions will be automatically saved and invested to generate extra income for you.\n";
                $message .= "Sidooh, Earns you money on every purchase";

                break;

            default:
                $message = "Congratulations! You have successfully registered as a {$type->title} on {$date}, valid until {$end_date}. ";
                $message .= "You will earn commissions on every airtime purchased by your referred customers and subagents up to your {$type->level_limit}. ";
                $message .= "Please note, 80% of your commissions will be automatically saved and invested to generate extra income for you.\n";
                $message .= "Sidooh, Earns you money on every purchase";
        }

        (new AfricasTalkingApi())->sms($phone, $message);
    }
}
