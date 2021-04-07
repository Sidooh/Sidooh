<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
//        //
//        Log::info($transaction->parent);
////        Log::info($transaction->parentAndSelf);
//        $transaction['level_' . '1' . '_ancestors'] = $transaction->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($transaction->ancestors);
////        Log::info($transaction->ancestorsAndSelf);
//        Log::info($transaction->siblings);
////        Log::info($transaction->siblingsAndSelf);
//        Log::info($transaction->children);
////        Log::info($transaction->childrenAndSelf);
//        Log::info($transaction->descendants);
////        Log::info($transaction->descendantsAndSelf);

        return new TransactionResource($transaction);
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
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function referrals(Transaction $transaction)
    {
        //
        return new TransactionResource($this->transaction->with(['pending_referrals', 'active_referrals'])->find($transaction->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function referrer(Request $request, Transaction $transaction)
    {
        //

        return new TransactionResource($this->transaction->getReferrer($transaction, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function subscriptions(Transaction $transaction)
    {
        //
        return new TransactionResource($this->transaction->with(['active_subscription'])->find($transaction->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function vouchers(Transaction $transaction)
    {
        //
        return new TransactionResource($transaction->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function earnings(Transaction $transaction)
    {
        //
        return new TransactionResource($this->transaction->earningsSummary($transaction->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function earningsReport(Transaction $transaction)
    {
        //

        return $this->transaction->earningsReport($transaction->phone);
        return new TransactionResource($this->transaction->earningsReport($transaction->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Transaction $transaction
//     * @return TransactionResource
//     */
    public function subTransactions(Transaction $transaction)
    {
        //
        return new TransactionResource($this->transaction->invest());
    }

}
