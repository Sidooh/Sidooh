<?php

namespace App\Listeners;

use App\Model\Payment;
use App\Repositories\ProductRepository;
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
        $mpesa_response = $event->mpesa_response;// mpesa response as array

        $airtime = [
            'phone' => $stk->PhoneNumber,
            'amount' => $stk->Amount
        ];

        $p = Payment::wherePaymentId($stk->id)->firstOrFail();
        $p->status = 'Complete';

        $p->save();

        (new ProductRepository())->airtime($p->payable, $airtime);
    }
}
