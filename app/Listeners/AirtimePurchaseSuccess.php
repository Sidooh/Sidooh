<?php

namespace App\Listeners;

use App\Events\AirtimePurchaseSuccessEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Repositories\NotificationRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Log;

class AirtimePurchaseSuccess
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
     * @param AirtimePurchaseSuccessEvent $event
     * @return void
     */
    public function handle(AirtimePurchaseSuccessEvent $event)
    {
        //
//        TODO:: Send sms notification

        Log::info('----------------- Airtime Purchase Success ');

        $phone = ltrim($event->airtime_response->phoneNumber, '+');
        $sender = $event->airtime_response->request->transaction->account->phone;
        $method = $event->airtime_response->request->transaction->payment->subtype;

        $amount = str_replace(' ', '', explode(".", $event->airtime_response->amount)[0]);
        $date = $event->airtime_response->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $points_earned = $this->getPointsEarned(explode(' ', $event->airtime_response->discount)[1]);

        $code = config('services.at.ussd.code');

        if ($method == 'VOUCHER') {
            $bal = $event->airtime_response->request->transaction->account->voucher->balance;
            $vtext = " New Voucher balance is KES$bal.";
        } else {
            $method = 'MPESA';
            $vtext = '';
        }

        (new TransactionRepository())->statusUpdate($event->airtime_response);

        if ($phone != $sender) {
            $message = "You have purchased {$amount} airtime for {$phone} from your Sidooh account on {$date} using $method. You have received {$points_earned} cashback.$vtext";

            NotificationRepository::sendSMS([$sender], $message);

            $message = "Congratulations! You have received {$amount} airtime from Sidooh account {$sender} on {$date}. Sidooh Makes You Money with Every Purchase.\n\nDial $code NOW for FREE on your Safaricom line to BUY AIRTIME & START EARNING from your purchases.";

            NotificationRepository::sendSMS([$phone], $message);
        } else {

            $message = "You have purchased {$amount} airtime from your Sidooh account on {$date} using $method. You have received {$points_earned} cashback.$vtext";

            NotificationRepository::sendSMS([$phone], $message);
        }

    }

//    TODO: Refactor this to external file?
    public function getPointsEarned(float $discount)
    {
        $e = $discount * config('services.sidooh.earnings.users_percentage');
        return 'KES' . $e / 6;
    }
}
