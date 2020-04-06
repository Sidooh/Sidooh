<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Samerior\MobileMoney\Mpesa\Events\B2cPaymentSuccessEvent;

class B2CPaymentSent
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
     * @param B2cPaymentSuccessEvent $event
     * @return void
     */
    public function handle(B2cPaymentSuccessEvent $event)
    {
        //
        Log::info('------------------------ B2C Payment Sent ' . now() . ' ---------------------- ');

        $stk = $event->response; //an instance of mpesa callback model

        Log::info($event->response);

//        $mpesa_response = $event->mpesa_response;// mpesa response as array
//
//        $other_phone = explode(" - ", $stk->request->description);
//
//        $p = Payment::wherePaymentId($stk->id)->firstOrFail();
//        $p->status = 'Complete';
//
//        $p->save();
//
//        switch ($stk->request->reference) {
//            case '001-AIRTIME':
//                if (count($other_phone) > 1)
//                    $airtime = [
//                        'phone' => $other_phone[1],
//                        'amount' => $stk->Amount
//                    ];
//                else
//                    $airtime = [
//                        'phone' => $stk->PhoneNumber,
//                        'amount' => $stk->Amount
//                    ];
//
//                (new ProductRepository())->airtime($p->payable, $airtime);
//
//                break;
//
//            case '002-SUBS':
//
//                (new ProductRepository())->subscription($p->payable, $stk->Amount);
//        }


    }
}
