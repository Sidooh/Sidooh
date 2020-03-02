<?php

namespace App\Listeners;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use Illuminate\Support\Facades\Log;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentSuccessEvent;

class StkPaymentReceived
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
     * @param StkPushPaymentSuccessEvent $event
     * @return void
     */
    public function handle(StkPushPaymentSuccessEvent $event)
    {
        //
        $stk = $event->stk_callback; //an instance of mpesa callback model
        $mpesa_request = $event->mpesa_response;// mpesa response as array

        $response = (new AfricasTalkingApi())->airtime('+' . $stk->PhoneNumber, $stk->Amount);

        Log::info([$stk, $mpesa_request, $response]);
    }
}
