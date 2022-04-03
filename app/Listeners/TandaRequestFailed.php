<?php

namespace App\Listeners;

use App\Helpers\SidoohNotify\EventTypes;
use App\Models\Transaction;
use App\Repositories\NotificationRepository;
use App\Repositories\TransactionRepository;
use DrH\Tanda\Events\TandaRequestFailedEvent;
use DrH\Tanda\Library\Providers;
use Illuminate\Support\Facades\Log;

class TandaRequestFailed
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
     * @param TandaRequestFailedEvent $event
     * @return void
     */
    public function handle(TandaRequestFailedEvent $event)
    {
        //
        Log::info('----------------- Tanda Request Failed ', [
            'id' => $event->request->id,
            'message' => $event->request->message
        ]);

        //                Update Transaction
        if ($event->request->relation_id) {
            $transaction = Transaction::find($event->request->relation_id);
        } else {
            $transaction = Transaction::whereStatus('pending')
                ->whereType('PAYMENT')
                ->whereAmount($event->request->amount)
                ->whereLike('description', 'LIKE', "%" . $event->request->destination)
                ->whereDate('createdAt', '<', $event->request->created_at);
            $event->request->relation_id = $transaction->id;
            $event->request->save();
        }

        (new TransactionRepository())->updateStatus($transaction, 'Failed');

        $destination = $event->request->destination;
        $sender = $transaction->account->phone;

        $amount = $transaction->amount;
        $date = $event->request->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $provider = $event->request->provider;

        $voucher = $transaction->account->voucher;
        $voucher->in += $amount;
        $voucher->save();

        $transaction->status = 'reimbursed';
        $transaction->save();

        switch ($provider) {
            case Providers::FAIBA:
            case Providers::SAFARICOM:
            case Providers::AIRTEL:
            case Providers::TELKOM:

                $message = "Hi, we have added KES{$amount} to your voucher account because we could not complete your KES{$amount} airtime purchase for {$destination} on {$date}.  New Voucher balance is {$voucher->balance}.";

                NotificationRepository::sendSMS([$sender], $message, EventTypes::AIRTIME_PURCHASE_FAILURE);

                break;

            case Providers::KPLC_POSTPAID:


//                $message = "Sorry! We could not complete your payment to {$provider} of KES{$amount} for {$destination} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";
//                (new AfricasTalkingApi())->sms($sender, $message);
//
//                break;

            case Providers::KPLC_PREPAID:

//                $message = "Sorry! We could not complete your payment to {$provider} of KES{$amount} for {$destination} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";
//                (new AfricasTalkingApi())->sms($sender, $message);
//
//                break;

            case Providers::DSTV:
            case Providers::GOTV:
            case Providers::ZUKU:
            case Providers::STARTIMES:

//                $message = "Sorry! We could not complete your payment to {$provider} of KES{$amount} for {$destination} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";
//                (new AfricasTalkingApi())->sms($sender, $message);
//
//                break;

            case Providers::NAIROBI_WTR:

                $message = "Hi, we have added KES{$amount} to your voucher account because we could not complete your payment to {$provider} of KES{$amount} for {$destination} on {$date}.  New Voucher balance is {$voucher->balance}.";
                NotificationRepository::sendSMS([$sender], $message, EventTypes::UTILITY_PAYMENT_FAILURE);
//
//                break;

        }

    }
}
