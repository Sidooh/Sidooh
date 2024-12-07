<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CollectiveInvestment;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;

class CollectiveInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param CollectiveInvestment $collectiveInvestment
     * @return \Illuminate\Http\Response
     */
    public function show(CollectiveInvestment $collectiveInvestment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CollectiveInvestment $collectiveInvestment
     * @return \Illuminate\Http\Response
     */
    public function edit(CollectiveInvestment $collectiveInvestment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CollectiveInvestment $collectiveInvestment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CollectiveInvestment $collectiveInvestment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CollectiveInvestment $collectiveInvestment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollectiveInvestment $collectiveInvestment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return float|\Illuminate\Http\Response|int
     */
    public function storeRate(Request $request)
    {
        //
        if ($request->has('rate'))
            return (new AccountRepository())->calculateInterest($request->rate);

        return "Failed to calculate Interest";
    }
}
