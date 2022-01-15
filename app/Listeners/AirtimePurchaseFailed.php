<?php

namespace App\Listeners;

use App\Events\AirtimePurchaseFailedEvent;
use App\Repositories\NotificationRepository;
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
        Log::info($event->airtime_response);
//        Adding failed airtime alert
        try {
            NotificationRepository::sendSMS(['254714611696', '254711414987', '254721309253'], "ERROR:AIRTIME\n{$event->airtime_response->phoneNumber}");
            Log::info("Airtime Failure SMS Sent");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

//        TODO: Refund money to voucher
        $phone = ltrim($event->airtime_response->phoneNumber, '+');
        $account = $event->airtime_response->request->transaction->account;

        $amount = explode(".", explode(" ", $event->airtime_response->amount)[1])[0];
        $date = $event->airtime_response->request->created_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

//        TODO: Find a better way to get the transaction cause of gateway error from AT and transaction seems empty
//        $transaction = new $event->airtime_response->request->transaction;
//        $transaction->status = 'reimbursed';
//        $transaction->save();

        $voucher = $account->voucher;
        $voucher->in += $amount;
        $voucher->save();

//        TODO:: Send sms notification
        $message = "Sorry! We could not complete your KES{$amount} airtime purchase for {$phone} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";

        NotificationRepository::sendSMS([$phone], $message);

    }
}
