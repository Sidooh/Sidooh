<?php

namespace App\Listeners;

use App\Events\AirtimePurchaseSuccessEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Log;

class AirtimePurchaseSuccess
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
     * @param AirtimePurchaseSuccessEvent $event
     * @return void
     */
    public function handle(AirtimePurchaseSuccessEvent $event)
    {
        //
//        TODO:: Send sms notification

        Log::info('------------------------ Airtime Purchase Success ' . now() . ' ---------------------- ');

        $phone = ltrim($event->airtime_response->phoneNumber, '+');
        $amount = explode(".", $event->airtime_response->amount)[0];
        $date = $event->airtime_response->updated_at->format(config("settings.sms_date_time_format"));

        $message = "You have received {$amount} airtime from Sidooh via MPESA account {$phone} on {$date}. Dial *144# to check your balance. \n\nSidooh, Makes You Money!";

        (new AfricasTalkingApi())->sms($phone, $message);

        (new TransactionRepository())->statusUpdate($event->airtime_response);
    }
}
