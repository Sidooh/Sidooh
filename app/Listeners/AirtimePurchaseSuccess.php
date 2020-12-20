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

        $amount = str_replace(' ', '', explode(".", $event->airtime_response->amount)[0]);
        $date = $event->airtime_response->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $points_earned = $this->getPointsEarned(explode(' ', $event->airtime_response->discount)[1]);

        if ($phone != $sender) {
            $message = "Congratulations! You have bought {$amount} airtime for {$phone} from your Sidooh account on {$date}. You have received {$points_earned} cashback.";

            (new AfricasTalkingApi())->sms($sender, $message);

            $message = "Congratulations! You have received {$amount} airtime from Sidooh account {$sender} on {$date}.";

            (new AfricasTalkingApi())->sms($phone, $message);
        } else {

            $message = "Congratulations! You have bought {$amount} airtime from your Sidooh account on {$date}. You have received {$points_earned} cashback.";

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
