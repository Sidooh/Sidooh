<?php


namespace App\Helpers\Sidooh;


use App\Model\Payment;
use App\Model\SubscriptionType;
use App\Model\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class Subscription
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Subscription type.
     *
     * @var SubscriptionType
     */
    protected $type;

    /**
     * Purchase method.
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
    public function __construct(SubscriptionType $type, $phone, $method = 'MPESA')
    {
        $this->type = $type;
        $this->phone = $phone;
        $this->method = $method;
    }

//    TODO: Add Assert checks
    public function purchase($targetNumber = null, $mpesaNumber = null)
    {
        Log::info('====== Subscription Purchase ======');

//        assertNotNull($this->type);

        $description = $targetNumber ? "Subscription Purchase - $targetNumber" : "Subscription Purchase";
        $number = $mpesaNumber ?? $this->phone;

        $stkResponse = mpesa_request($number, (int)$this->type->amount / 10, '002-SUBS', $description);

        $accountRep = new AccountRepository();
//        $account = $accountRep->create([
//            'phone' => $this->phone
//        ]);
        $account = $accountRep->findByPhone($this->phone);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Subscription']);

        $transaction = new Transaction();

        $transaction->amount = (int)$this->type->amount;
        $transaction->type = 'PAYMENT';
        $transaction->type = 'Subscription Purchase';
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();

        $payment = new Payment([
            'amount' => (int)$this->type->amount,
            'status' => 'Pending',
            'type' => 'MPESA',
            'subtype' => 'STK',
            'payment_id' => $stkResponse->id
        ]);

        $transaction->payment()->save($payment);

    }
}