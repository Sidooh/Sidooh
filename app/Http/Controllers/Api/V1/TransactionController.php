<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Model\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
    public function index()
    {
        //
        return new TransactionResource($this->repo->with(['payment'])->get());
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
}
