<?php


namespace App\Models\Helpers\Sidooh;


use App\Models\Model\Payment;
use App\Models\Model\SubscriptionType;
use App\Models\Model\Transaction;
use App\Models\Repositories\AccountRepository;
use App\Models\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class Voucher
{
    /**
     * Phone number to purchase voucher for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Purchase method.
     *
     * @var string
     */
    protected $method;

    /**
     * Make the initializations required to purchase airtime
     * @param $phone
     * @param string $method
     */
    public function __construct($phone, $amount, $method = 'MPESA')
    {
        $this->phone = $phone;
        $this->amount = $amount;
        $this->method = $method;
    }

//    TODO: Add Assert checks
    public function purchase($targetNumber = null, $mpesaNumber = null)
    {
        Log::info('====== Voucher Purchase ======');

        $description = $targetNumber ? "Voucher Purchase - $targetNumber" : "Voucher Purchase";
        $number = $mpesaNumber ?? $this->phone;


        $stkResponse = mpesa_request($number, $this->amount, '003.2-VOUCHER', $description);


        $accountRep = new AccountRepository();
//        $account = $accountRep->create([
//            'phone' => $this->phone
//        ]);
        $account = $accountRep->findByPhone($this->phone);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Voucher']);

        $transaction = new Transaction();

        $transaction->amount = $this->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = 'Voucher Purchase';
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
