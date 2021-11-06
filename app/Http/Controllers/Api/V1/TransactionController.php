<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Artisan;

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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function queryMpesaStatus()
    {
        //
        $exitCode = Artisan::call('mpesa:query_status');

        return back();
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function queryKyandaStatus()
    {
        //
        $exitCode = Artisan::call('kyanda:query_status');

        return back();
    }

}
