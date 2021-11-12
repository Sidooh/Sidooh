<?php

namespace App\Listeners;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Nabcellent\Kyanda\Events\KyandaRequestEvent;
use Nabcellent\Kyanda\Events\KyandaTransactionSuccessEvent;
use Nabcellent\Kyanda\Library\Providers;
use Propaganistas\LaravelPhone\PhoneNumber;

class KyandaRequest
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
    public function handle(KyandaRequestEvent $event)
    {
        //
        Log::info('----------------- Kyanda Request: ' . $event->request->status . ' - ' . $event->request->message);

        $transaction = Transaction::find($event->request->relation_id);

        $date = $event->request->created_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $account = $transaction->account;

        $phone = ltrim($account->phone, '+');

        $amount = $transaction->amount;

        if (!in_array($event->request->status_code, ['0000', '1100'])) {
            try {
                (new AfricasTalkingApi())->sms(['254714611696', '254711414987'], "KY_ERR:{$event->request->provider}\n{$event->request->message}\n{$transaction->account->phone} - $date");
                Log::info("Kyanda Failure SMS Sent");
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

            $transaction->status = 'reimbursed';
            $transaction->save();

            $voucher = $account->voucher;
            $voucher->in += $amount;
            $voucher->save();


            switch ($event->request->provider) {
                case Providers::SAFARICOM:
                case Providers::AIRTEL:
                case Providers::FAIBA:
                case Providers::EQUITEL:
                case Providers::TELKOM:

                    $message = "Sorry! We could not complete your KES{$amount} airtime purchase on {$date}. We have added KES{$amount} to your voucher. New Voucher balance is {$voucher->balance}.";

                    break;

                default:

                    $accountNo = explode(" - ", $transaction->description)[1];

                    $message = "Sorry! We could not complete your KES{$amount} {$event->request->provider} payment for {$accountNo} on {$date}. We have added KES{$amount} to your voucher. New Voucher balance is {$voucher->balance}.";

            }

            (new AfricasTalkingApi())->sms($phone, $message);

        }

        switch ($event->request->provider) {
            case Providers::SAFARICOM:
            case Providers::AIRTEL:
            case Providers::FAIBA:
            case Providers::EQUITEL:
            case Providers::TELKOM:
            case Providers::FAIBA_B:

                break;

            default:

                $number = explode(" - ", $transaction->description)[1];

                (new AccountRepository())->syncUtilityAccounts($account, $event->request->provider, $number);

        }

    }
}
