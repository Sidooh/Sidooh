<?php


namespace App\Helpers\Sidooh;


use App\Model\Payment;
use App\Model\Transaction;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReferralRepository;
use Illuminate\Support\Facades\Log;
use libphonenumber\NumberParseException;

class Airtime
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Airtime amount.
     *
     * @var integer
     */
    protected $amount;

    /**
     * Purchase method.
     *
     * @var string
     */
    protected $method;

    /**
     * Make the initializations required to purchase airtime
     * @param $amount
     * @param $phone
     * @param string $method
     */
    public function __construct($amount, $phone, $method = 'MPESA')
    {
        $this->amount = $amount;
        $this->phone = $phone;
        $this->method = $method;
    }

    public function parse_text($text)
    {
        return explode('*', $text);
    }

    public static function ussdProcessor(UssdUser $user, array $result, $message)
    {
        if ($user->session == 1 && count($result) > 1) {
            switch ($message) {
                case 1:
                    $user->session = 11;
                    break;
                case 2:
                    $user->session = 12;
                    break;
                default:
                    $user->session = 1;
            }

            $user->save();
        }

        if ($user->session == 1211) {
            switch ($message) {
                case 1:
                    $user->session = 12111;
            }
        }

        if ($user->session == 1111) {
            switch ($message) {
                case 1:
                    $user->session = 11111;
            }
        }

        if ($user->session == 121) {
            if ((int)$message > 4 && (int)$message < 10000)
                $user->session = 1211;
        }

        if ($user->session == 111) {
            switch ($message) {
                case 1:
                    $user->session = 1111;
            }
        }

        if ($user->session == 12) {
            try {
                if (ReferralRepository::validatePhone($message))
                    $user->session = 121;
            } catch (NumberParseException $e) {

            }
        }

        if ($user->session == 11) {
            if ((int)$message > 4 && (int)$message < 10000)
                $user->session = 111;
        }

        $user->save();

        switch ($user->session) {
            case 121:
            case 11:
                $response = "Enter amount: \n(Min: Ksh 5. Max: Ksh 10,000) \n\n";

                break;

            case 12:
                $response = "Enter phone number \n\n";

                break;

            case 111:
//                TODO: fetch from DB
                $amount = 5;

                $response = "Buy Ksh $amount airtime for $user->phone using: \n";
                $response .= "1. MPESA \n";
                $response .= "2. Sidooh Points \n";
                $response .= "3. Sidooh Bonus \n";
                $response .= "4. Other \n\n";

                break;

            case 1111:
                $amount = 5;

                $response = "CON Ksh $amount airtime for $user->phone will be deducted from your MPESA\n";
                $response .= "1. Accept \n";
                $response .= "2. Cancel \n\n";

                break;

            case 1211:
                $amount = 5;

                $response = "Buy Ksh $amount airtime for $user->phone using: \n";
                $response .= "1. MPESA \n";
                $response .= "2. Sidooh Points \n";
                $response .= "3. Sidooh Bonus \n";
                $response .= "4. Other \n\n";

                break;

            case 12111:
            case 11111:
                $amount = 5;

                (new Airtime($amount, $user->phone))->purchase();

                $response = "END Your request has been received and is being processed. You will receive a confirmation SMS shortly. \nThank you.";

                break;

            default:

                $response = "Buy airtime for: \n";
                $response .= "1. Self ($user->phone) \n";
                $response .= "2. Other Number\n\n";

        }

        $response .= "\n0. Go back \t00. Go Home";

        return $response;
    }

    public function purchase($targetNumber = null, $mpesaNumber = null)
    {
        Log::info('====== Airtime Purchase ======');

        $description = ($targetNumber ? "Airtime Purchase - $targetNumber" : $mpesaNumber) ? "Airtime Purchase - $this->phone" : "Airtime Purchase";
        $number = $mpesaNumber ?? $this->phone;

        $stkResponse = mpesa_request($number, $this->amount, '001-AIRTIME', $description);

        error_log(json_encode($stkResponse));

        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Airtime']);

        $transaction = new Transaction();

        $transaction->amount = $this->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = $targetNumber ? "Airtime Purchase - $targetNumber" : "Airtime Purchase";
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();

        $payment = new Payment([
            'amount' => $this->amount,
            'status' => 'Pending',
            'type' => 'MPESA',
            'subtype' => 'STK',
            'payment_id' => $stkResponse->id
        ]);

        $transaction->payment()->save($payment);
    }
}
