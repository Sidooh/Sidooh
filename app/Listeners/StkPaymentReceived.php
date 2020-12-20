<?php

namespace App\Listeners;

use App\Models\Payment;
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
        Log::info('----------------- STK Payment Received ');

        $stk = $event->stk_callback; //an instance of mpesa callback model
//        $mpesa_response = $event->mpesa_response;// mpesa response as array

//        Log::info($stk);
//        Log::info($mpesa_response);

        $other_phone = explode(" - ", $stk->request->description);

        $p = Payment::wherePaymentId($stk->request->id)->firstOrFail();
        $p->status = 'Complete';

        $p->save();

        switch ($stk->request->reference) {
            case '001-AIRTIME':
                if (count($other_phone) > 1)
                    $airtime = [
                        'phone' => $other_phone[1],
                        'amount' => $stk->Amount
                    ];
                else
                    $airtime = [
                        'phone' => $stk->PhoneNumber ?? $stk->request->phone,
                        'amount' => $stk->Amount
                    ];

                (new ProductRepository())->airtime($p->payable, $airtime);

                break;

            case '002-SUBS':
            case '006.1-PRE_SUBS':
            case '006.2-SUBS':

                (new ProductRepository())->subscription($p->payable, $stk->Amount);
                break;

            case '003.2-VOUCHER':
                if (count($other_phone) > 1)
                    $voucherDetails = [
                        'phone' => $other_phone[1],
                        'amount' => $stk->Amount
                    ];
                else
                    $voucherDetails = [
                        'phone' => $stk->PhoneNumber ?? $stk->request->phone,
                        'amount' => $stk->Amount
                    ];

                (new ProductRepository())->voucher($p->payable, $voucherDetails);
                break;

        }


    }
}
