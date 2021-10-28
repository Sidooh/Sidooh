<?php

namespace App\Listeners;

use App\Helpers\Kyanda\KyandaApi;
use App\Helpers\Sidooh\USSD\Entities\MpesaReferences;
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

        $other_phone = explode(" - ", $stk->request->description);

        $p = Payment::wherePaymentId($stk->request->id)->whereSubtype('STK')->firstOrFail();

        if ($p->status == 'Complete')
            return;

        $p->status = 'Complete';

        $p->save();

        switch ($stk->request->reference) {
            case MpesaReferences::AIRTIME:
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

                if (config('services.sidooh.provider') == 'kyanda')
                    KyandaApi::airtime($p->payable, $airtime);
                else
                    (new ProductRepository())->airtime($p->payable, $airtime);

                break;

            case MpesaReferences::PAY_SUBSCRIPTION:
            case MpesaReferences::PRE_AGENT_REGISTER_ASPIRING:
            case MpesaReferences::PRE_AGENT_REGISTER_THRIVING:
            case MpesaReferences::AGENT_REGISTER_ASPIRING:
            case MpesaReferences::AGENT_REGISTER_THRIVING:
            case MpesaReferences::AGENT_REGISTER:

                (new ProductRepository())->subscription($p->payable, $stk->Amount);
                break;

            case MpesaReferences::PAY_VOUCHER:
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

            case MpesaReferences::PAY_UTILITY:
                $billDetails = [
                    'account' => $other_phone[1],
                    'amount' => $stk->Amount
                ];
                $provider = explode(" ", $stk->request->description)[0];
                KyandaApi::bill($p->payable, $billDetails, $provider);
        }


    }
}
