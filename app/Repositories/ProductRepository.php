<?php


namespace App\Repositories;


use App\Events\AirtimePurchaseEvent;
use App\Events\AirtimePurchaseFailedEvent;
use App\Events\AirtimePurchaseSuccessEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Model\Product;
use App\Model\Transaction;
use App\Models\AirtimeRequest;
use App\Models\AirtimeResponse;
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
        $response = (new AfricasTalkingApi())->airtime($array['phone'], $array['amount']);

        $response = $this->object_to_array($response);

        $req = AirtimeRequest::create($response['data']);

        $req->transaction()->associate($transaction);

        DB::transaction(function () use ($req, $response) {
            $req->save();

            $req->responses()->createMany($response['data']['responses']);

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
}