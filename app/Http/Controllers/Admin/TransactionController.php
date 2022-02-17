<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SidoohNotify\EventTypes;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\NotificationRepository;
use App\Repositories\TransactionRepository;
use DrH\Mpesa\Database\Entities\MpesaBulkPaymentResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

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
        $transactions = $this->transaction->latest()->simplePaginate(50);

        return view('admin.crud.transactions.index', compact('transactions'));
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return View|Factory|Application
     */
    public function show(Transaction $transaction): View|Factory|Application
    {
        $transaction->load(['account']);
//
        if ($transaction->payment)
            if ($transaction->payment->subtype == 'STK')
                $transaction->load(['payment.stkRequest.response']);
            elseif ($transaction->payment->subtype == 'B2C') {
                $transaction->load(['payment.b2cRequest']);

                $transaction->payment->b2cRequest->response = MpesaBulkPaymentResponse::with('data')
                    ->where('ConversationID', $transaction->payment->b2cRequest->conversation_id)->first();
            }

        return view('admin.crud.transactions.show', compact('transaction'));
    }

    /**
     * Display the specified resource.
     *
     * @return RedirectResponse
     */
    public function queryStatus()
    {
        //
        $exitCode = Artisan::call('mpesa:query_status');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @return RedirectResponse
     */
    public function queryRequestStatus()
    {
        //
        $exitCode = Artisan::call('tanda:query_status');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function refund(Request $request, Transaction $transaction)
    {
        //
//         Check transaction has airtime or payment is successful but airtime failed
        if ($transaction->payment) {
            if (mb_strtolower($transaction->payment->status) == 'complete') {
                if ($transaction->request) {
                    if (!in_array($transaction->request->status, ['000000', '000001'])) {
//                        TODO: Perform refund

                        $this->performRefund($transaction);
                    }
                } else {
                    $this->performRefund($transaction);
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
     * @return RedirectResponse
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
     * @return RedirectResponse
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
     * @return RedirectResponse
     */
    public function markBothComplete(Request $request, Transaction $transaction)
    {

        $this->markComplete($request, $transaction);
        $this->markPaymentComplete($request, $transaction->payment);

        return back();

    }

    private function performRefund(Transaction $transaction)
    {
        $account = $transaction->account;
        $phone = $account->phone;

        $amount = $transaction->amount;
        $date = $transaction->updated_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $voucher = $transaction->account->voucher;
        $voucher->in += $amount;
        $voucher->save();

        $transaction->status = 'reimbursed';
        $transaction->save();

        $description = explode(" - ", $transaction->description);
        $destination = count($description) > 1 ? " for " . $description[1] : "";
        $description = $description[0];

        $message = "Sorry! We could not complete your KES{$amount} {$description}{$destination} on {$date}. We have added KES{$amount} to your voucher account. New Voucher balance is {$voucher->balance}.";

        NotificationRepository::sendSMS([$phone], $message, EventTypes::VOUCHER_REFUND);
    }
}
