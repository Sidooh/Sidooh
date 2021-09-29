<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Samerior\MobileMoney\Mpesa\Database\Entities\MpesaBulkPaymentResponse;

class TransactionController extends Controller
{
    protected $transaction;

    /**
     * TransactionController constructor.
     *
     * @param TransactionRepository $transaction
     */
    public function __construct(TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $transactions = $this->transaction->latest()->get();

        return view('admin.crud.transactions.index', compact('transactions'));
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
     * @param TransactionStoreRequest $request
     * @return TransactionResource
     */
    public function store(TransactionStoreRequest $request)
    {
        //
        return new TransactionResource($this->transaction->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['account']);
//
        if ($transaction->payment->subtype == 'STK')
            $transaction->load(['payment.stkRequest.response']);
        elseif ($transaction->payment->subtype == 'B2C') {
            $transaction->load(['payment.b2cRequest']);

            $transaction->payment->b2cRequest->response = MpesaBulkPaymentResponse::with('data')
                ->where('ConversationID', $transaction->payment->b2cRequest->conversation_id)->first();
        }

//        return new TransactionResource($transaction);

        return view('admin.crud.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Transaction $transaction
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

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function queryStatus()
    {
        //

        $exitCode = Artisan::call('mpesa:query_status');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refund(Request $request, Transaction $transaction)
    {
        //
//         Check transaction has airtime or payment is successful but airtime failed
        if ($transaction->payment) {
            if (mb_strtolower($transaction->payment->status) == 'complete') {
                if ($transaction->airtime) {
                    if ($transaction->airtime->errorMessage != 'None'
                        || ($transaction->airtime->response && $transaction->airtime->response->status == 'Failed')) {
//                        TODO: Perform refund

                        $account = $transaction->account;
                        $phone = $account->phone;

                        $amount = $transaction->amount;
                        $date = $transaction->airtime->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

                        $voucher = $transaction->account->voucher;
                        $voucher->in += $amount;
                        $voucher->save();

                        $transaction->status = 'reimbursed';
                        $transaction->save();

                        $message = "Sorry! We could not complete your KES{$amount} airtime purchase for {$phone} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";

                        (new AfricasTalkingApi())->sms($phone, $message);
                    }
                }
            }
        }

        return back();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markComplete(Request $request, Transaction $transaction)
    {

        if ($transaction->payment) {
            if (mb_strtolower($transaction->payment->status) == 'complete') {

                $transaction->status = 'completed';
                $transaction->save();

            }
        }

        return back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markPaymentComplete(Request $request, Payment $payment)
    {
        if (mb_strtolower($payment->status) != 'complete') {

            $payment->status = 'Complete';
            $payment->save();
        }

        return back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markBothComplete(Request $request, Transaction $transaction)
    {

        $this->markComplete($request, $transaction);
        $this->markPaymentComplete($request, $transaction->payment);

        return back();

    }
}
