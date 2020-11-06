<?php


namespace App\Helpers\Sidooh;


use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class Merchant
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Merchant.
     *
     * @var \App\Models\Merchant
     */
    protected $merchant;

    /**
     * Purchase method.
     *
     * @var string
     */
    protected $method;

    /**
     * Make the initializations required to purchase airtime
     * @param \App\Models\Merchant $merchant
     * @param $phone
     * @param string $method
     */
    public function __construct(\App\Models\Merchant $merchant, $phone, $method = 'MPESA')
    {
        $this->merchant = $merchant;
        $this->phone = $phone;
        $this->method = $method;
    }

//    TODO: Add Assert checks
    public function purchase(int $amount)
    {
        Log::info('====== Merchant Purchase ======');

        $accountRep = new AccountRepository();
        $account = $accountRep->findByPhone($this->phone);

        $voucher = $account->voucher;
        $voucher->out += $amount;

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Merchant']);

        $transaction = new Transaction();

        $transaction->amount = $amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = 'Merchant Payment';
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();

        $payment = new Payment([
            'amount' => $amount,
            'status' => 'Pending',
            'type' => 'SIDOOH',
            'subtype' => 'VOUCHER',
            'payment_id' => $voucher->id
        ]);

        $transaction->payment()->save($payment);

        (new ProductRepository())->merchant($transaction, $airtime);
    }
}
