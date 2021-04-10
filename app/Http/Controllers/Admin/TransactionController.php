<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
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

        if ($transaction->payment->type == 'MPESA')
            $transaction->load(['payment.descriptor.response']);

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

}
