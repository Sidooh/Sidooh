<?php

namespace App\Listeners;

use App\Events\MerchantPurchaseEvent;
use App\Events\TransactionSuccessEvent;
use App\Helpers\SidoohNotify\EventTypes;
use App\Repositories\NotificationRepository;
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

        Log::info('----------------- Merchant Purchase Success');

        $amount = $event->transaction->amount;
        $account = $event->transaction->account;
        $merchant = $event->merchant;

        $phone = ltrim($account->phone, '+');
        $mPhone = ltrim($merchant->contact_number, '+');

        $date = $event->transaction->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $message = "SIDOOH transaction confirmed. Ksh{$amount} paid to {$merchant->name}";
        $message .= " on {$date}. New VOUCHER balance is {$account->voucher->balance}.\n\n";
        $message .= "Sidooh, Earns you money on every purchase.";

        NotificationRepository::sendSMS([$phone], $message, EventTypes::MERCHANT_PAYMENT);

        $message = "SIDOOH transaction confirmed. You have received Ksh{$amount} from {$account->user->name} {$phone}";
        $message .= " on {$date}. New Account balance is {$merchant->balance}.\n\n";
        $message .= "Sidooh, Earns you money on every purchase.";

        NotificationRepository::sendSMS([$mPhone], $message, EventTypes::MERCHANT_PAYMENT);

        $amount = $event->transaction->amount * .025 <= 250 ? $event->transaction->amount * .025 : 250;

        event(new TransactionSuccessEvent($event->transaction, $amount));
    }
}
