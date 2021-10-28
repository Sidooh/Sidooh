<?php

namespace App\Listeners;

use App\Events\TransactionSuccessEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Nabcellent\Kyanda\Events\KyandaTransactionSuccessEvent;
use Nabcellent\Kyanda\Library\Providers;
use Propaganistas\LaravelPhone\PhoneNumber;

class KyandaTransactionSuccess
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
     * @param KyandaTransactionSuccessEvent $event
     * @return void
     */
    public function handle(KyandaTransactionSuccessEvent $event)
    {
        //
        Log::info('----------------- Kyanda Transaction Success ');
        Log::info($event->transaction->request->provider);

        switch ($event->transaction->request->provider) {
            case Providers::SAFARICOM:
            case Providers::AIRTEL:
            case Providers::FAIBA:
            case Providers::EQUITEL:
            case Providers::TELKOM:
//                Update Transaction
                $transaction = Transaction::find($event->transaction->request->relation_id);
                (new TransactionRepository())->updateStatus($transaction, 'completed');

//                Get Points Earned
                $totalEarnings = .07 * $transaction->amount;
                $userEarnings = $this->getPointsEarned($totalEarnings);

//                Update Earnings
                event(new TransactionSuccessEvent($transaction, $totalEarnings));

//                Send SMS

                $phone = ltrim(PhoneNumber::make($event->transaction->destination, 'KE')->formatE164(), '+');
                $sender = $transaction->account->phone;
                $method = $transaction->payment->subtype;

                $amount = $transaction->amount;
                $date = $event->transaction->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

                if ($method == 'VOUCHER') {
                    $bal = $transaction->account->voucher->balance;
                    $vtext = " New Voucher balance is KES$bal.";
                } else {
                    $method = 'MPESA';
                    $vtext = '';
                }

                $code = config('services.at.ussd.code');


                if ($phone != $sender) {
                    $message = "You have purchased {$amount} airtime for {$phone} from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

                    (new AfricasTalkingApi())->sms($sender, $message);

                    $message = "Congratulations! You have received {$amount} airtime from Sidooh account {$sender} on {$date}. Sidooh Makes You Money with Every Purchase.\n\nDial $code NOW for FREE on your Safaricom line to BUY AIRTIME & START EARNING from your purchases.";

                    (new AfricasTalkingApi())->sms($phone, $message);
                } else {

                    $message = "You have purchased {$amount} airtime from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

                    (new AfricasTalkingApi())->sms($phone, $message);
                }

                break;

            case Providers::KPLC_POSTPAID:


                break;


            case Providers::KPLC_PREPAID:


                break;

            case Providers::DSTV:
            case Providers::GOTV:
            case Providers::ZUKU:
            case Providers::STARTIMES:


                break;

            case Providers::NAIROBI_WTR:


                break;

            case Providers::FAIBA_B:

                break;

        }

    }

    public function getPointsEarned(float $discount): string
    {
        $e = $discount * .75;
        return 'KES' . $e / 6;
    }
}
