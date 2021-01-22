<?php


namespace App\Repositories;


use App\Events\AirtimePurchaseFailedEvent;
use App\Events\AirtimePurchaseSuccessEvent;
use App\Events\MerchantPurchaseEvent;
use App\Events\SubscriptionPurchaseEvent;
use App\Events\VoucherPurchaseEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Models\AirtimeRequest;
use App\Models\AirtimeResponse;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MrAtiebatie\Repository;

class ProductRepository
{

    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = app(Product::class);
    }

    public function store(array $array): Product
    {
        $prod = $this->firstOrCreate($array);

        return $prod;
    }

    public function airtime(Transaction $transaction, array $array): AirtimeRequest
    {
        if ($transaction->airtime)
            exit;

        $response = (new AfricasTalkingApi())->airtime($array['phone'], $array['amount']);

        $response = $this->object_to_array($response);

        $req = AirtimeRequest::create($response['data']);

        $req->transaction()->associate($transaction);

        DB::transaction(function () use ($req, $response) {
            $req->save();

            $req->responses()->createMany($response['data']['responses']);

        });

        if ($response['data']['errorMessage'] != "None") {
//            TODO: Modify event to accept request instead of response
//            event(new AirtimePurchaseFailedEvent($response));

//            TODO: Once above is modified, the following code won't be needed.
            $account = $req->transaction->account;
            $amount = $req->transaction->amount;
            $phone = $account->phone;
            $date = $req->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

            $voucher = $account->voucher;
            $voucher->in += $amount;
            $voucher->save();

//        TODO:: Send sms notification
            $message = "Sorry! We could not complete your airtime purchase for {$phone} worth {$amount} on {$date}. We have credited your voucher {$amount} and your balance is now {$voucher->balance}.";

            (new AfricasTalkingApi())->sms($phone, $message);
        }


        return $req;

    }

    public function airtimeCallback(array $all)
    {
        $res = AirtimeResponse::where('requestID', '=', $all['requestId'])->firstOrFail();
        if ($res->status != 'Success') {
            $res->status = $all['status'];
            $res->save();

            $this->fireAirtimePurchaseEvent($res, $all);

        }
    }

    private function fireAirtimePurchaseEvent(AirtimeResponse $response, array $request)
    {
//        TODO:: Remove Sent from airtime purchase event
//        || $request['status'] == 'Sent'
        if ($request['status'] == 'Success') {
            event(new AirtimePurchaseSuccessEvent($response));
        } else {
            event(new AirtimePurchaseFailedEvent($response));
        }
//        return $response;
    }

    function object_to_array($obj)
    {
        //only process if it's an object or array being passed to the function
        if (is_object($obj) || is_array($obj)) {
            $ret = (array)$obj;
            foreach ($ret as &$item) {
                //recursively process EACH element regardless of type
                $item = $this->object_to_array($item);
            }
            return $ret;
        } //otherwise (i.e. for scalar values) return without modification
        else {
            return $obj;
        }
    }

    public function subscription(Transaction $transaction, int $amount): Subscription
    {
//        Log::info($transaction);
//        Log::info($transaction->amount);
//        Log::info((int)$transaction->amount);

//        DB::transaction(function () use ($sub, $amount, $transaction) {

        error_log('-------------------');
        error_log($transaction->amount);
        error_log('-------------------');

        $type = SubscriptionType::whereAmount($transaction->amount)->firstOrFail();

        $subscription = [
            'amount' => $amount,
            'active' => true,
            'account_id' => $transaction->account->id,
            'subscription_type_id' => $type->id
        ];

        $sub = Subscription::create($subscription);

//        $sub->subscription_type()->associate($type);
//        $sub->account()->associate($transaction->account);

        $transaction->status = 'success';
        $transaction->save();

        $sub->save();

//        });

//        Log::info($sub);

        event(new SubscriptionPurchaseEvent($sub, $transaction));

        return $sub;
    }


    public function voucher(Transaction $transaction, array $array): Voucher
    {
//        Log::info($transaction);
//        Log::info($transaction->amount);
//        Log::info((int)$transaction->amount);

//        DB::transaction(function () use ($sub, $amount, $transaction) {

        $voucher = (new VoucherRepository())->storeOrCreate($array);

        $voucher->in += $transaction->amount;
        $voucher->save();

        $transaction->status = 'success';
        $transaction->save();


//        });

//        Log::info($voucher);

        event(new VoucherPurchaseEvent($voucher, $transaction));

        return $voucher;
    }

    public function merchant(Transaction $transaction, Merchant $merchant): Transaction
    {
        $merchant->in += $transaction->amount;
        $payment = $transaction->payment;
        $payment->status = "Success";

        $merchant->save();
        $payment->save();

        event(new MerchantPurchaseEvent($merchant, $transaction));

        return $transaction;
    }
}
