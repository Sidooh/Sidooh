<?php


namespace App\Helpers\Sidooh;


use App\Helpers\Sidooh\USSD\Entities\MpesaReferences;
use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Models\Payment;
use App\Models\SubscriptionType;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;
use DrH\Mpesa\Exceptions\MpesaException;

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
     * Purchase amount.
     *
     * @var int
     */
    protected $amount;

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

        $this->amount = ceil($this->type->amount);

//        if ($this->type->amount > 1000)
//            $this->amount = ceil($this->type->amount / 500);
//        else
//            $this->amount = ceil($this->type->amount / 50);
    }

//    TODO: Add Assert checks
    public function purchase($targetNumber = null, $mpesaNumber = null)
    {
        Log::info("====== Subscription Purchase ($this->method) ======");


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
        $description = $targetNumber ? "Subscription Purchase - $targetNumber" : "Subscription Purchase";
        $number = $mpesaNumber ?? $this->phone;

        switch ($this->type->amount) {
            case 4350:
                $reference = MpesaReferences::PRE_AGENT_REGISTER_THRIVING;
                break;
            case 4275:
                $reference = MpesaReferences::PRE_AGENT_REGISTER_ASPIRING;
                break;
            case 975:
                $reference = MpesaReferences::AGENT_REGISTER_THRIVING;
                break;
            case 475:
                $reference = MpesaReferences::AGENT_REGISTER_ASPIRING;
                break;
            case 365:
                $reference = MpesaReferences::AGENT_REGISTER;
                break;
        }

        try {
            $stkResponse = mpesa_request($number, $this->amount, $reference, $description);
        } catch (MpesaException $e) {
            Log::error($e->getMessage());
//            (new AfricasTalkingApi())->sms($number, "Sorry there was an issue with processing the request.");
            return;
        }

//        TODO: Refactor this into the constructor?
        $accountRep = new AccountRepository();
        $account = $accountRep->findByPhone($this->phone);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Subscription']);

        $transaction = new Transaction();

        $transaction->amount = $this->type->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = 'Subscription Purchase';
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

//        TODO: Refactor end

        $transaction->save();

        $payment = new Payment([
            'amount' => $this->type->amount,
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
        $voucher->out += $this->type->amount;

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Subscription']);

        $transaction = new Transaction();

        $transaction->amount = $this->type->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = 'Subscription Purchase';
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();

        $payment = new Payment([
            'amount' => $this->type->amount,
            'status' => 'Pending',
            'type' => 'SIDOOH',
            'subtype' => 'VOUCHER',
            'payment_id' => $voucher->id
        ]);

        $transaction->payment()->save($payment);
        $voucher->save();

        (new ProductRepository())->subscription($transaction, $this->type->amount);
    }
}
