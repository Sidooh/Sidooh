<?php

namespace App\Listeners;

use App\Events\AirtimePurchaseSuccessEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
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

//        Log::info($event->airtime_response);
//        Log::info($event->airtime_response->request->transaction);

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
            $vtext = '';
        }

        if ($phone != $sender) {
            $message = "Well done! You have purchased {$amount} airtime for {$phone} from your Sidooh account on {$date} using $method. You have received {$points_earned} cashback.$vtext";

            (new AfricasTalkingApi())->sms($sender, $message);

            $message = "Congratulations! You have received {$amount} airtime from Sidooh account {$sender} on {$date}. Sidooh Makes You Money with Every Purchase.\n\n Dial $code NOW for FREE on your Safaricom line to BUY AIRTIME & START EARNING from your purchases.";

            (new AfricasTalkingApi())->sms($phone, $message);
        } else {

            $message = "Awesome! You have purchased {$amount} airtime from your Sidooh account on {$date} using $method. You have received {$points_earned} cashback.$vtext";

            (new AfricasTalkingApi())->sms($phone, $message);
        }

        (new TransactionRepository())->statusUpdate($event->airtime_response);
    }

    public function getPointsEarned(float $discount)
    {
        $e = $discount * .75;
        return 'KES' . $e / 6;
    }
}
