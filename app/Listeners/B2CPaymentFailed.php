<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Samerior\MobileMoney\Mpesa\Events\B2cPaymentFailedEvent;

class B2CPaymentFailed
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
     * @param B2cPaymentFailedEvent $event
     * @return void
     */
    public function handle(B2cPaymentFailedEvent $event)
    {
        //
        Log::info('------------------------ B2C Payment Failed ' . now() . ' ---------------------- ');

        $stk = $event->response; //an instance of mpesa callback model
//        $mpesa_response = $event->mpesa_response;// mpesa response as array

        Log::info($event->response);

//        $message = "We failed to carry out your transaction. No amount was debited from your account.\nSorry for the inconvenience, please try again...\n\nSidooh, Makes You Money!";

//        (new AfricasTalkingApi())->sms($stk->request->phone, $message);
    }
}
