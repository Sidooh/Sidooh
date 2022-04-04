<?php

namespace App\Listeners;

use App\Events\TransactionSuccessEvent;
use App\Helpers\SidoohNotify\EventTypes;
use App\Models\Transaction;
use App\Repositories\NotificationRepository;
use App\Repositories\TransactionRepository;
use DrH\Tanda\Events\TandaRequestSuccessEvent;
use DrH\Tanda\Library\Providers;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;

class TandaRequestSuccess
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

    public function getTelcoFromPhone(int $phone): string
    {
        $safReg = '/^(?:254|\+254|0)?((?:7(?:[0129][0-9]|4[0123568]|5[789]|6[89])|(1([1][0-5])))[0-9]{6})$/';
        $airReg = '/^(?:254|\+254|0)?((?:(7(?:(3[0-9])|(5[0-6])|(6[27])|(8[0-9])))|(1([0][0-6])))[0-9]{6})$/';
        $telReg = '/^(?:254|\+254|0)?(7(7[0-9])[0-9]{6})$/';
        $equReg = '/^(?:254|\+254|0)?(7(6[3-6])[0-9]{6})$/';
        $faibaReg = '/^(?:254|\+254|0)?(747[0-9]{6})$/';

        return match (1) {
            preg_match($safReg, $phone) => Providers::SAFARICOM,
            preg_match($airReg, $phone) => Providers::AIRTEL,
            preg_match($telReg, $phone) => Providers::TELKOM,
            preg_match($faibaReg, $phone) => Providers::FAIBA,
//            preg_match($equReg, $phone) => Providers::EQUITEL,
            default => null,
        };
    }

    /**
     * Handle the event.
     *
     * @param TandaRequestSuccessEvent $event
     * @return void
     */
    public function handle(TandaRequestSuccessEvent $event)
    {
        //
        Log::info('----------------- Tanda Request Success ', [$event->request]);

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

        $provider = $event->request->provider;

        if (empty($provider)) {
            $descArray = explode(" - ", $transaction->description);
            $productString = explode(" ", $descArray[0]);

            if ($productString[0] == "Airtime") {
                $provider = $this->getTelcoFromPhone($descArray[1]);
            } else {
                $provider = $productString[0];
            }

            $event->request->provider = $provider;
            $event->request->save();
        }

        $method = $transaction->payment->subtype;

        if ($method == 'VOUCHER') {
            $bal = $transaction->account->voucher->balance;
            $vtext = " New Voucher balance is KES$bal.";
        } else {
            $method = 'MPESA';
            $vtext = '';
        }

        $code = config('services.at.ussd.code');

        $destination = $event->request->destination;
        $sender = $transaction->account->phone;

        $amount = $transaction->amount;
        $date = $event->request->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        switch ($provider) {
            case Providers::FAIBA:
            case Providers::SAFARICOM:
            case Providers::AIRTEL:
            case Providers::TELKOM:

//                Get Points Earned
                if ($provider == Providers::FAIBA)
                    $totalEarnings = .07 * $transaction->amount;
                else
                    $totalEarnings = .06 * $transaction->amount;

                $userEarnings = $this->getPointsEarned($totalEarnings);

//                Update Earnings
                event(new TransactionSuccessEvent($transaction, $totalEarnings));

                $phone = ltrim(PhoneNumber::make($destination, 'KE')->formatE164(), '+');

//                Send SMS
                if ($phone != $sender) {
                    $message = "You have purchased {$amount} airtime for {$phone} from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

                    NotificationRepository::sendSMS([$sender], $message, EventTypes::AIRTIME_PURCHASE);

                    $message = "Congratulations! You have received {$amount} airtime from Sidooh account {$sender} on {$date}. Sidooh Makes You Money with Every Purchase.\n\nDial $code NOW for FREE on your Safaricom line to BUY AIRTIME & START EARNING from your purchases.";

                    NotificationRepository::sendSMS([$phone], $message, EventTypes::AIRTIME_PURCHASE);
                } else {

                    $message = "You have purchased {$amount} airtime from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

                    NotificationRepository::sendSMS([$phone], $message, EventTypes::AIRTIME_PURCHASE);
                }

                break;

            case Providers::KPLC_POSTPAID:
                //                Get Points Earned
                $totalEarnings = .017 * $transaction->amount;
                $userEarnings = $this->getPointsEarned($totalEarnings);

//                Update Earnings
                event(new TransactionSuccessEvent($transaction, $totalEarnings));

//                Send SMS
                $message = "You have made a payment to {$provider} - {$destination} of {$amount} from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

                NotificationRepository::sendSMS([$sender], $message, EventTypes::UTILITY_PAYMENT);

                break;


            case Providers::KPLC_PREPAID:
//                Get Points Earned
                $totalEarnings = .017 * $transaction->amount;
                $userEarnings = $this->getPointsEarned($totalEarnings);

//                Update Earnings
                event(new TransactionSuccessEvent($transaction, $totalEarnings));

//                Send SMS
                $details = $event->request->result;
                $message = "You have made a payment to {$provider} - {$destination} of {$amount} from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";
                $message .= "\nTokens: {$details[0]['value']}\nUnits: {$details[1]['value']}";

                NotificationRepository::sendSMS([$sender], $message, EventTypes::UTILITY_PAYMENT);

                break;

            case Providers::DSTV:
            case Providers::GOTV:
            case Providers::ZUKU:
            case Providers::STARTIMES:
//                Get Points Earned
                $totalEarnings = .003 * $transaction->amount;
                $userEarnings = $this->getPointsEarned($totalEarnings);

//                Update Earnings
                event(new TransactionSuccessEvent($transaction, $totalEarnings));

//                Send SMS
                $message = "You have made a payment to {$provider} - {$destination} of {$amount} from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

            NotificationRepository::sendSMS([$sender], $message, EventTypes::UTILITY_PAYMENT);

                break;

            case Providers::NAIROBI_WTR:
                //                Get Points Earned
                $totalEarnings = 5;
                $userEarnings = $this->getPointsEarned($totalEarnings);

//                Update Earnings
                event(new TransactionSuccessEvent($transaction, $totalEarnings));

//                Send SMS
                $message = "You have made a payment to {$provider} - {$destination} of {$amount} from your Sidooh account on {$date} using $method. You have received {$userEarnings} cashback.$vtext";

                NotificationRepository::sendSMS([$sender], $message, EventTypes::UTILITY_PAYMENT);

                break;

        }

        (new TransactionRepository())->updateStatus($transaction, 'completed');
        Log::info('============ Completed Transaction');
    }

//    TODO: Refactor function to helper file?
    public function getPointsEarned(float $discount): string
    {
        $e = $discount * config('services.sidooh.earnings.users_percentage');
        return 'KES' . $e / 6;
    }
}
