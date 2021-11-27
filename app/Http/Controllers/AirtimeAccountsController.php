<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAirtimeAccountsRequest;
use App\Http\Requests\UpdateAirtimeAccountsRequest;
use App\Models\AirtimeAccounts;

class AirtimeAccountsController extends Controller
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
     * @param \App\Http\Requests\StoreAirtimeAccountsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAirtimeAccountsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\AirtimeAccounts $airtimeAccounts
     * @return \Illuminate\Http\Response
     */
    public function show(AirtimeAccounts $airtimeAccounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\AirtimeAccounts $airtimeAccounts
     * @return \Illuminate\Http\Response
     */
    public function edit(AirtimeAccounts $airtimeAccounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAirtimeAccountsRequest $request
     * @param \App\Models\AirtimeAccounts $airtimeAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAirtimeAccountsRequest $request, AirtimeAccounts $airtimeAccounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\AirtimeAccounts $airtimeAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirtimeAccounts $airtimeAccounts)
    {
        //
    }
}
