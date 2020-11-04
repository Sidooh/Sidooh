<?php


namespace App\Helpers\Sidooh;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;

class Airtime
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected string $phone;

    /**
     * Airtime amount.
     *
     * @var integer
     */
    protected int $amount;

    /**
     * Purchase method.
     *
     * @var
     */
    protected $method;

    /**
     * Make the initializations required to purchase airtime
     * @param $amount
     * @param $phone
     * @param $method
     */
    public function __construct($amount, $phone, $method = PaymentMethods::MPESA)
    {
        $this->amount = $amount;
        $this->phone = PhoneNumber::make($phone, 'KE')->formatE164();
        $this->method = $method;
    }

    public function purchase($targetNumber = null, $mpesaNumber = null)
    {
        Log::info('====== Airtime Purchase ======');

        switch ($this->method) {
            case PaymentMethods::MPESA:
                $this->mpesa($targetNumber, $mpesaNumber);
                break;
            case PaymentMethods::VOUCHER:
                $this->voucher($targetNumber);
                break;
        }


    }

    public function mpesa($targetNumber = null, $mpesaNumber = null)
    {
        $targetNumber = $targetNumber ? PhoneNumber::make($targetNumber, 'KE')->formatE164() : null;
        $mpesaNumber = $mpesaNumber ? PhoneNumber::make($mpesaNumber, 'KE')->formatE164() : null;

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

    public function voucher($targetNumber = null, $mpesaNumber = null)
    {

        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        $voucher = $account->voucher;
        $voucher->out += $this->amount;

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
            'type' => 'VOUCHER',
            'subtype' => '',
            'payment_id' => $voucher->id
        ]);

        $transaction->payment()->save($payment);
        $voucher->save();

        $airtime = [
            'phone' => $targetNumber ? PhoneNumber::make($targetNumber, 'KE')->formatE164() : $this->phone,
            'amount' => $this->amount
        ];
        (new ProductRepository())->airtime($transaction, $airtime);
    }
}
