<?php

namespace App\Listeners;

use App\Helpers\SidoohNotify\EventTypes;
use App\Models\Payment;
use App\Repositories\NotificationRepository;
use DrH\Mpesa\Events\StkPushPaymentFailedEvent;
use Illuminate\Support\Facades\Log;

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

//        TODO: Can we inform the user of the actual issue?
        $message = "Sorry! We failed to complete your transaction. No amount was deducted from your account. We apologize for the inconvenience. Please try again.";

        NotificationRepository::sendSMS([$stk->request->phone], $message, EventTypes::PAYMENT_FAILURE);

    }
}
