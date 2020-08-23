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
