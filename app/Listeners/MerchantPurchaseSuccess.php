<?php

namespace App\Listeners;

use App\Events\MerchantPurchaseEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use Illuminate\Support\Facades\Log;

class MerchantPurchaseSuccess
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
     * @param MerchantPurchaseEvent $event
     * @return void
     */
    public function handle(MerchantPurchaseEvent $event)
    {
        //
//        TODO:: Send sms notification

        Log::info('------------------------ Merchant Purchase Success ' . now() . ' ---------------------- ');

        $amount = $event->transaction->amount;
        $account = $event->transaction->account->refresh();
        $merchant = $event->merchant->refresh();

        $phone = ltrim($account->phone, '+');
        $mPhone = ltrim($merchant->contact_number, '+');

        $date = $event->transaction->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $message = "SIDOOH transaction confirmed. Ksh{$amount} paid to {$merchant->name}";
        $message .= " on {$date}. New VOUCHER balance is {$account->voucher->balance}.\n\n";
        $message .= "Sidooh, Earns you money on every purchase.";

        (new AfricasTalkingApi())->sms($phone, $message);

        $message = "SIDOOH transaction confirmed. Ksh{$amount} paid to {$merchant->name}";
        $message .= " on {$date}. New Account balance is {$merchant->balance}.\n\n";
        $message .= "Sidooh, Earns you money on every purchase.";

        (new AfricasTalkingApi())->sms($mPhone, $message);
    }
}
