<?php


namespace App\Listeners;

use DrH\Mpesa\Database\Entities\MpesaStkRequest;
use DrH\Mpesa\Events\C2bConfirmationEvent;
use Illuminate\Support\Facades\Log;

class C2bPaymentConfirmation
{
    /**
     * Handle the event.
     *
     * @param C2bConfirmationEvent $event
     * @return void
     */
    public function handle(C2bConfirmationEvent $event)
    {
        Log::info(array($event));

        $c2b = $event->transaction;
        //Try to check if this was from STK
        $request = MpesaStkRequest::whereReference($c2b->BillRefNumber)->first();

        Log::info($request);
    }
}
