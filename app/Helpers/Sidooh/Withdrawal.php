<?php


namespace App\Helpers\Sidooh;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Models\Payment;
use App\Models\SubscriptionType;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;

class Withdrawal
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Withdrawal amount.
     *
     * @var integer
     */
    protected int $amount;

    /**
     * Withdraw method.
     *
     * @var string
     */
    protected $method;

    /**
     * Make the initializations required to purchase airtime
     * @param SubscriptionType $type
     * @param $phone
     * @param string $method
     */
    public function __construct($amount, $phone, $method = PaymentMethods::MPESA)
    {
        $this->amount = $amount;
        $this->phone = ltrim(PhoneNumber::make($phone, 'KE')->formatE164(), '+');
        $this->method = $method;
    }

//    TODO: Add Assert checks
    public function withdraw($targetNumber = null)
    {
        Log::info("====== Withdrawal ($this->method) ======");
        Log::info("$this->phone - $targetNumber");

        switch ($this->method) {
            case PaymentMethods::MPESA:
                $this->mpesa($targetNumber);
                break;
//            case PaymentMethods::VOUCHER:
//                $this->voucher($targetNumber);
//                break;
        }


    }

    public function mpesa($mpesaNumber = null)
    {
        $number = $mpesaNumber ?? $this->phone;

        $description = $mpesaNumber ? "Withdrawal - $mpesaNumber" : "Withdrawal";

        if (config('services.sidooh.mpesa.env') == 'local') {
            $number = config('services.sidooh.mpesa.b2c.phone');
        }

        $b2c = mpesa_send($number, $this->amount, $description);

//        Log::info($b2c);


        DB::transaction(function () use ($mpesaNumber, $b2c) {

            $accountRep = new AccountRepository();
            $account = $accountRep->findByPhone($this->phone);

            $productRep = new ProductRepository();
            $product = $productRep->store(['name' => 'Withdrawal']);

            $transaction = new Transaction();

            $transaction->amount = $this->amount;
            $transaction->type = 'WITHDRAWAL';
            $transaction->description = $mpesaNumber ? "Withdrawal of Points - $mpesaNumber" : "Withdrawal of Points";
            $transaction->account_id = $account->id;
            $transaction->product_id = $product->id;

            $transaction->save();

            $payment = new Payment([
                'amount' => $this->amount,
                'status' => 'Pending',
                'type' => 'MPESA',
                'subtype' => 'B2C',
                'payment_id' => $b2c->id
            ]);

            $transaction->payment()->save($payment);

        }, 3);

    }

}
