<?php

namespace App\Listeners;

use App\Model\Payment;
use App\Repositories\ProductRepository;
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
        Log::info('------------------------ STK Payment Received ' . now() . ' ---------------------- ');

        $stk = $event->stk_callback; //an instance of mpesa callback model
        $mpesa_response = $event->mpesa_response;// mpesa response as array

        $other_phone = explode(" - ", $stk->request->description);

        if (count($other_phone) > 1)
            $airtime = [
                'phone' => $other_phone[1],
                'amount' => $stk->Amount
            ];
        else
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
