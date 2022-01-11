<?php

namespace App\Listeners;

use App\Events\VoucherPurchaseEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Log;

class VoucherPurchaseSuccess
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
     * @param VoucherPurchaseEvent $event
     * @return void
     */
    public function handle(VoucherPurchaseEvent $event)
    {
        //
//        TODO:: Send sms notification

        Log::info('----------------- Voucher Purchase Success ');

        $amount = $event->transaction->amount;
        $account = $event->voucher->account;

        $phone = ltrim($account->phone, '+');

        $date = $event->voucher->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $message = "Congratulations! You have successfully purchased a voucher ";
        $message .= "worth Ksh{$amount} on {$date}.\n\n";
        $message .= config('services.sidooh.tagline');

        (new AfricasTalkingApi())->sms($phone, $message);
        NotificationRepository::sendSMS([$phone], $message);

    }
}
