<?php


namespace App\Helpers\Sidooh;


use App\Model\Payment;
use App\Model\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

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

    public static function ussdProcessor($phoneNumber, $level, $text)
    {
        Log::info($level);

        switch ($level) {
            case 1:
                // Business logic for first level response
                $response = "CON Buy airtime for: \n";
                $response .= "1. Self ($phoneNumber) \n";
                $response .= "2. Other Number\n\n";

                break;

            case 2:
                $response = "CON Enter amount: \n(Min: Ksh 5. Max: Ksh 10,000) \n\n";

                break;

            case 3:
                $amount = $text[$level];

                if ((int)$amount < 5 || (int)$amount > 9999)
                    $response = "CON Please enter VALID amount: \n(Min: Ksh 5. Max: Ksh 10,000) \n\n";
                else {

                    $response = "CON Buy Ksh $amount airtime for $phoneNumber using: \n";
                    $response .= "1. MPESA \n";
                    $response .= "2. Sidooh Points \n";
                    $response .= "3. Sidooh Bonus \n";
                    $response .= "4. Other \n\n";

                }

                break;
            case 4:
                $amount = $text[$level - 1];

                $response = "CON Ksh $amount airtime for $phoneNumber will be deducted from your MPESA\n";
                $response .= "1. Accept \n";
                $response .= "2. Cancel \n\n";

            case 5:
                (new Airtime($amount, $phoneNumber))->purchase();

                // This is a terminal request. Note how we start the response with END
                $response = "END Your request has been received and is being processed. You will receive a confirmation SMS shortly. \nThank you.";
        }

        return $response;

    }

    public function purchase($phone = null)
    {
        Log::info('====== Airtime Purchase ======');

        if ($phone)
            $stkResponse = mpesa_request($this->phone, $this->amount, '001-AIRTIME', "Airtime Purchase - $phone");
        else
            $stkResponse = mpesa_request($this->phone, $this->amount, '001-AIRTIME', 'Airtime Purchase');

        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Airtime']);

        $transaction = new Transaction();

        $transaction->amount = $this->amount;
        $transaction->type = 'Payment';
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