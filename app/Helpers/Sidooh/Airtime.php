<?php


namespace App\Helpers\Sidooh;


use App\Helpers\Sidooh\USSD\Entities\MpesaReferences;
use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use http\Exception\InvalidArgumentException;
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
        $this->phone = ltrim(PhoneNumber::make($phone, 'KE')->formatE164(), '+');
        $this->method = $method;
    }

    public function purchase($targetNumber = null, $mpesaNumber = null)
    {
        Log::info("====== Airtime Purchase ($this->method) ======");
        $targetNumber = $targetNumber ? ltrim(PhoneNumber::make($targetNumber, 'KE')->formatE164(), '+') : $this->phone;
        $mpesaNumber = $mpesaNumber ? ltrim(PhoneNumber::make($mpesaNumber, 'KE')->formatE164(), '+') : '';
        Log::info("$targetNumber - $mpesaNumber");

        switch ($this->method) {
            case PaymentMethods::MPESA:
                return $this->mpesa($targetNumber, $mpesaNumber);
                break;
            case PaymentMethods::VOUCHER:
                return $this->voucher($targetNumber);
                break;
        }

    }

    public function mpesa($targetNumber = null, $mpesaNumber = null)
    {
        $description = $targetNumber ? "Airtime Purchase - $targetNumber" : "Airtime Purchase";
        $number = !empty($mpesaNumber) ?: $this->phone;

        $stkResponse = mpesa_request($number, $this->amount, MpesaReferences::AIRTIME, $description);

//        error_log(json_encode($stkResponse));

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

        return $transaction;
    }

    public function voucher($targetNumber = null)
    {
        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        $voucher = $account->voucher;

        if ($account->voucher) {
            $bal = $account->voucher->balance;
            if ($bal == 0 || $bal < (int)$this->amount) {
                throw new InvalidArgumentException("Voucher balance insufficient");
            }
        }

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
            'type' => 'SIDOOH',
            'subtype' => 'VOUCHER',
            'payment_id' => $voucher->id
        ]);

        $transaction->payment()->save($payment);
        $voucher->save();

        $airtime = [
            'phone' => $targetNumber ? PhoneNumber::make($targetNumber, 'KE')->formatE164() : $this->phone,
            'amount' => $this->amount
        ];
        (new ProductRepository())->airtime($transaction, $airtime);

        return $transaction;
    }
}
