<?php


namespace App\Helpers\Sidooh;


use App\Helpers\Kyanda\KyandaApi;
use App\Helpers\Sidooh\USSD\Entities\MpesaReferences;
use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;
use Nabcellent\Kyanda\Library\Providers;
use Propaganistas\LaravelPhone\PhoneNumber;

class Utility
{
    /**
     * Phone number doing payment.
     *
     * @var string
     */
    protected string $phone;

    /**
     * Utility option.
     *
     * @var string
     */
    protected string $option;

    /**
     * Amount to pay option.
     *
     * @var int
     */
    protected int $amount;

    /**
     * Account number to pay bill for.
     *
     * @var string
     */
    protected string $accountNumber;

    /**
     * Purchase method.
     *
     * @var string
     */
    protected string $method;

    /**
     * Make the initializations required to purchase airtime
     * @param $phone
     * @param int $option
     * @param int $amount
     * @param string $method
     */
    public function __construct($phone, int $option, int $amount, int $accountNumber, string $method = PaymentMethods::MPESA)
    {
        $this->phone = ltrim(PhoneNumber::make($phone, 'KE')->formatE164(), '+');
        $this->amount = $amount;
        $this->accountNumber = $accountNumber;
        $this->method = $method;

        switch ($option) {
            case 1:
                $this->option = Providers::KPLC_PREPAID;
                break;
            case 2:
                $this->option = Providers::KPLC_POSTPAID;
                break;
            case 3:
                $this->option = Providers::NAIROBI_WTR;
                break;
            case 4:
                $this->option = Providers::DSTV;
                break;
            case 5:
                $this->option = Providers::ZUKU;
                break;
            case 6:
                $this->option = Providers::GOTV;
                break;
            case 7:
                $this->option = Providers::STARTIMES;
                break;
        }
    }

//    TODO: Add Assert checks
    public function purchase($mpesaNumber = null)
    {
        Log::info('====== Utility Purchase ======');

        $mpesaNumber = $mpesaNumber ? ltrim(PhoneNumber::make($mpesaNumber, 'KE')->formatE164(), '+') : '';

        Log::info("$this->accountNumber - $this->phone");

        switch ($this->method) {
            case PaymentMethods::MPESA:
                $this->mpesa($mpesaNumber);
                break;
            case PaymentMethods::VOUCHER:
                $this->voucher();
                break;
        }
    }

    public function mpesa($mpesaNumber = null)
    {
        $description = $this->option . " Payment - $this->accountNumber";
        $number = $mpesaNumber ?? $this->phone;

        $stkResponse = mpesa_request($number, $this->amount, MpesaReferences::PAY_UTILITY, $description);

        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Utility']);

        $transaction = new Transaction();

        $transaction->amount = $this->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = $description;
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

    public function voucher()
    {
        $accountRep = new AccountRepository();
        $account = $accountRep->create([
            'phone' => $this->phone
        ]);

        $voucher = $account->voucher;

        if ($account->voucher) {
            $bal = $account->voucher->balance;
            if ($bal == 0 || $bal < $this->amount) {
                return;
            }
        }

        $voucher->out += $this->amount;

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Utility']);

        $transaction = new Transaction();

        $transaction->amount = $this->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = $this->option . " Payment - $this->accountNumber";
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();

        $payment = new Payment([
            'amount' => $this->amount,
            'status' => 'Complete',
            'type' => 'SIDOOH',
            'subtype' => 'VOUCHER',
            'payment_id' => $voucher->id
        ]);

        $transaction->payment()->save($payment);
        $voucher->save();

        $bill = [
            'account' => $this->accountNumber,
            'amount' => $this->amount
        ];

        KyandaApi::bill($transaction, $bill, $this->option, 700000000);
    }

}
