<?php


namespace App\Helpers\Sidooh;


use App\Model\SubscriptionType;
use App\Model\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class Withdrawal
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Withdrawal type.
     *
     * @var String
     */
    protected $type;

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
    public function __construct($phone, $method = 'MPESA')
    {
        $this->phone = $phone;
        $this->method = $method;
    }

//    TODO: Add Assert checks
    public function withdraw($amount, $mpesaNumber = null)
    {
        Log::info('====== Withdrawal ======');

        $description = $mpesaNumber ? "Withdrawal - $mpesaNumber" : "Withdrawal";
        $number = $mpesaNumber ?? $this->phone;

        $b2c = mpesa_send('254708374149', $amount, $description);

        Log::info($b2c);

        $accountRep = new AccountRepository();
        $account = $accountRep->findByPhone($this->phone);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Withdrawal']);

        $transaction = new Transaction();

        $transaction->amount = $amount;
        $transaction->type = 'WITHDRAWAL';
        $transaction->description = 'Withdrawal of Points';
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();
//
//        $payment = new Payment([
//            'amount' => (int)$this->type->amount,
//            'status' => 'Pending',
//            'type' => 'MPESA',
//            'subtype' => 'STK',
//            'payment_id' => $stkResponse->id
//        ]);
//
//        $transaction->payment()->save($payment);

    }

}