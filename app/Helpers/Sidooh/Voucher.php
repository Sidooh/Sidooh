<?php


namespace App\Helpers\Sidooh;


use App\Helpers\Sidooh\USSD\Entities\MpesaReferences;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
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

        $description = $targetNumber ? "Voucher Purchase - $targetNumber" : "Voucher Purchase - $this->phone";
        $number = $mpesaNumber ?? $this->phone;

        $stkResponse = mpesa_request($number, 10 ?? $this->amount, MpesaReferences::PAY_VOUCHER, $description);

        $accountRep = new AccountRepository();
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
