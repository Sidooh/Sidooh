<?php

namespace App\Listeners;

use App\Events\AirtimePurchaseFailedEvent;
use Illuminate\Support\Facades\Log;

class AirtimePurchaseFailed
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
     * @param AirtimePurchaseFailedEvent $event
     * @return void
     */
    public function handle(AirtimePurchaseFailedEvent $event)
    {
        //
//        TODO:: Send sms notification

        Log::info('----------------- Airtime Purchase Failed');


    }
}
