<?php

namespace App\Listeners;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentFailedEvent;

class StkPaymentFailed
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
     * @param StkPushPaymentFailedEvent $event
     * @return void
     */
    public function handle(StkPushPaymentFailedEvent $event)
    {
        //
        $stk = $event->stk_callback; //an instance of mpesa callback model
//        $mpesa_response = $event->mpesa_response;// mpesa response as array

        Log::info('----------------- STK Payment Failed (' . $stk->ResultDesc . ')');

//        TODO: Make into a transaction/try catch?
        $p = Payment::wherePaymentId($stk->request->id)->whereSubtype('STK')->firstOrFail();

        if ($p->status == 'Failed')
            return;

        $p->status = 'Failed';
        $p->save();

        $p->payable->status = 'Failed';
        $p->payable->save();

        $message = "Sorry! We failed to complete your transaction. No amount was deducted from your account. We apologize for the inconvenience. Please try again.";

        (new AfricasTalkingApi())->sms($stk->request->phone, $message);
    }
}
