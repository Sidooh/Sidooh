<?php

namespace App\Listeners;

use App\Events\AirtimePurchaseFailedEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use Illuminate\Support\Facades\Log;

class AirtimePurchaseFailed
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
     * @param AirtimePurchaseFailedEvent $event
     * @return void
     */
    public function handle(AirtimePurchaseFailedEvent $event)
    {
        //
        Log::info('----------------- Airtime Purchase Failed');

//        TODO: Refund money to voucher
        $phone = ltrim($event->airtime_response->phoneNumber, '+');
        $account = $event->airtime_response->request->transaction->account;

        $amount = explode(".", explode(" ", $event->airtime_response->amount)[1])[0];
        $date = $event->airtime_response->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

//        $transaction = new Transaction();
//
//        $transaction->amount = $amount;
//        $transaction->type = 'PAYMENT';
//        $transaction->description = 'Airtime Refund';
//        $transaction->account_id = $account->id;
//        $transaction->product_id = $product->id;

//        $transaction->save();

        $voucher = $account->voucher;
        $voucher->in += $amount;
        $voucher->save();

//        TODO:: Send sms notification
        $message = "Sorry! We could not complete your KES{$amount} airtime purchase for {$phone} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";

        (new AfricasTalkingApi())->sms($phone, $message);

    }
}
