<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Sidooh\B2B\B2B;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Model\Payment;
use App\Repositories\PaymentRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mpesa;
use Samerior\MobileMoney\Mpesa\Library\Core;

class PaymentController extends Controller
{
    protected $repo;

    /**
     * TransactionController constructor.
     *
     * @param PaymentRepository $repo
     */
    public function __construct(PaymentRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return PaymentResource
     */
    public function index()
    {
        //

        return new PaymentResource($this->repo->with(['payable'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     * @return void
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     * @return void
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Payment $payment
     * @return void
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $payment
     * @return void
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function b2b(Request $request)
    {
        $b2b = new B2B(new Core(new Client(['http_errors' => false,])), new \Samerior\MobileMoney\Mpesa\Repositories\Mpesa());
        $res = $b2b->send('123454', 100, 'Trial b2b');

//        $res = mpesa_send('600000', 100, 'Trial b2b');
//        $mpesa  = new Mpesa();
//
//        $res = $mpesa->b2b('10000','BusinessPayBill','60000','4','4','paytest','cool');

        return $res;

    }
}
