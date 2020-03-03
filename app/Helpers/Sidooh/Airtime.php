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

    public function purchase()
    {
        Log::info('====== Airtime Purchase ======');

//        $stkResponse = [];

        $stkResponse = mpesa_request($this->phone, $this->amount, '001-AIRTIME', 'Airtime Purchase');

        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        Log::info('------------ Account Creation ------------');
        Log::info([$account]);

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
            'type' => 'MPESA'
        ]);

        $transaction->payment()->save($payment);

//        $transaction->save();

        Log::info([$stkResponse, $account, $product, $transaction, $payment]);

//        return true;

//        return (new AfricasTalkingApi())->airtime($this->phone, $this->amount);
    }


}