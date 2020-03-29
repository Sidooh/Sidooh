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

        Log::info('------------------------ Subscription Purchase Success ' . now() . ' ---------------------- ');

        $type = $event->subscription->subscription_type;
        $account = $event->subscription->account;

        $phone = ltrim($account->phone, '+');
//        $sender = $event->airtime_response->request->transaction->account->phone;
//
//        $amount = explode(".", $event->airtime_response->amount)[0];
        $date = $event->subscription->created_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $message = "Your {$type->title} subscription purchased on {$date} has been activated. Dial *144# to check your balance. \n\nSidooh, Makes You Money!";

        (new AfricasTalkingApi())->sms($phone, $message);
//
//        (new TransactionRepository())->updateToSuccess($event->transaction);
    }
}
