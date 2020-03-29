<?php


namespace App\Repositories;


use App\Events\AirtimePurchaseEvent;
use App\Events\AirtimePurchaseFailedEvent;
use App\Events\AirtimePurchaseSuccessEvent;
use App\Events\SubscriptionPurchaseEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Model\Product;
use App\Model\SubscriptionType;
use App\Model\Transaction;
use App\Models\AirtimeRequest;
use App\Models\AirtimeResponse;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $response = (new AfricasTalkingApi())->airtime($array['phone'], $array['amount']);

        $response = $this->object_to_array($response);

        $req = AirtimeRequest::create($response['data']);

        $req->transaction()->associate($transaction);

        DB::transaction(function () use ($req, $response) {
            $req->save();

            $req->responses()->createMany($response['data']['responses']);

//            TODO:: Remove from here and await callback
            event(new AirtimePurchaseSuccessEvent($req->responses()->first()));

        });

        event(new AirtimePurchaseEvent($req));

        return $req;

    }

    public function airtimeCallback(array $all)
    {
        $res = AirtimeResponse::where('requestID', '=', $all['requestId'])->firstOrFail();
        $res->status = $all['status'];
        $res->save();

        $this->fireAirtimePurchaseEvent($res, $all);

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
        $subscription = [
            'amount' => $amount,
            'active' => true,
        ];

        Log::info((string)(int)$transaction->amount);

        $sub = Subscription::create($subscription);

//        DB::transaction(function () use ($sub, $amount, $transaction) {
        $type = SubscriptionType::whereAmount((string)(int)$transaction->amount)->firstOrFail();

        $sub->subscription_type()->associate($type);
        $sub->account()->associate($transaction->account);

        $transaction->status = 'success';
        $transaction->save();

        $sub->save();

//        });

        event(new SubscriptionPurchaseEvent($sub, $transaction));

        return $sub;

    }
}