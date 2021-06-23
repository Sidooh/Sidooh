<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Samerior\MobileMoney\Mpesa\Exceptions\MpesaException;

class TransactionController extends Controller
{
    protected $repo;

    /**
     * TransactionController constructor.
     *
     * @param TransactionRepository $repo
     */
    public function __construct(TransactionRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return TransactionResource
     */
    public function index(Account $account)
    {
        //
        Log::info(auth()->user());
        Log::info(\request());

//        TODO: Should we filter status here or in the frontend? SHoudl we show users failed and pending transactions?
        $data = $account->transactions()->whereIn('status', ['success', 'completed'])->with(['payment'])->get();

        return new TransactionResource($data);
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
     * @param \App\Models\Transaction $transaction
     * @return Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }


    public function mpesaStkPush(Request $request)
    {
//        $resp = (new Mpesa)->STK()->push('254714611696','1','Airtime Purchase','001-AIRT');

        $request = mpesa_request('254714611696', 1, '001-AIRT', 'Airtime Purchase');

        return response()->json($request);
    }

    public function mpesaStkPushCallback(Request $request)
    {
//        (new Mpesa)->STK()->push('254714611696','1','New Purchase','R3F3R3NC3');


        Log::info($request->all());

    }

    public function buyAirtime(Account $account, Request $request): \Illuminate\Http\JsonResponse
    {
        Log::info('******* API AIRTIME PURCHASE *******');

        $amount = $request->amount;
        $target = $request->other_phone;
        $method = $request->purchaseMethod;

        try {

//        TODO: Do we need to store all numbers bought for in our system? What if it is not a safaricom number?
            $transaction = (new \App\Helpers\Sidooh\Airtime($amount, $account->phone, $method))->purchase($target);

            $message = $method === 'MPESA' ? "STK Push sent successfully" : "Voucher purchase in progress";

            return response()
                ->json([
                    'status' => 'SUCCESS',
                    'message' => $message,
                    'data' => $transaction
                ]);

        } catch (MpesaException $e) {
            Log::error($e->getMessage());
            return response()
                ->json([
                    'status' => 'ERROR',
                    'message' => 'There was an error with MPesa servers. Please try again later.'
                ], 503);

        } catch (\InvalidArgumentException $e) {
            Log::error($e->getMessage());
            return response()
                ->json([
                    'status' => 'ERROR',
                    'message' => $e->getMessage()
                ], 503);
        }

    }

    public function getAirtimeStatus(Account $account, Transaction $transaction, Request $request): \Illuminate\Http\JsonResponse
    {
        if ($transaction->product_id != 1) {
            return response()
                ->json([
                    'status' => 'ERROR',
                    'message' => "This record does not exist",
                ], 404);
        }

        $transaction = $transaction->load(['airtime.response', 'payment.stkRequest.response']);

        if ($transaction->payment->stkRequest->status == "Requested") {
            dispatch(function () {
                $exitCode = Artisan::call('mpesa:query_status');
            });

            $transaction = $transaction->load(['airtime.response', 'payment.stkRequest.response']);
        }

        return response()
            ->json([
                'status' => 'SUCCESS',
                'message' => "Airtime status retrieved successfully",
                'data' => $transaction
            ]);

    }

    public function buyVoucher(Account $account, Request $request): \Illuminate\Http\JsonResponse
    {
        Log::info('******* API VOUCHER PURCHASE *******');

        $amount = $request->amount;
        $target = $request->other_phone;

        try {

//        TODO: Do we need to store all numbers bought for in our system? What if it is not a safaricom number?
            $transaction = (new \App\Helpers\Sidooh\Voucher($account->phone, $amount))->purchase($target);

        } catch (MpesaException $e) {
            Log::error($e->getMessage());
            return response()
                ->json([
                    'status' => 'ERROR',
                    'message' => 'There was an error with MPesa servers. Please try again later.'
                ], 503);
        }

        return response()
            ->json([
                'status' => 'SUCCESS',
                'message' => "STK Push sent successfully",
                'data' => $transaction
            ]);

    }

    public function getVoucherStatus(Account $account, Transaction $transaction, Request $request): \Illuminate\Http\JsonResponse
    {
        if ($transaction->product_id != 3) {
            return response()
                ->json([
                    'status' => 'ERROR',
                    'message' => "This record does not exist",
                ], 404);
        }

        $transaction = $transaction->load(['payment.stkRequest.response']);

        if ($transaction->payment->stkRequest->status == "Requested") {
            dispatch(function () {
                $exitCode = Artisan::call('mpesa:query_status');
            });

            $transaction = $transaction->load(['payment.stkRequest.response']);
        }

        return response()
            ->json([
                'status' => 'SUCCESS',
                'message' => "Voucher status retrieved successfully",
                'data' => $transaction
            ]);

    }

}
