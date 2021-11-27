<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUssdVarsRequest;
use App\Http\Requests\UpdateUssdVarsRequest;
use App\Models\UssdVars;

class UssdVarsController extends Controller
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
     * @param \App\Http\Requests\StoreUssdVarsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUssdVarsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UssdVars $ussdVars
     * @return \Illuminate\Http\Response
     */
    public function show(UssdVars $ussdVars)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\UssdVars $ussdVars
     * @return \Illuminate\Http\Response
     */
    public function edit(UssdVars $ussdVars)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUssdVarsRequest $request
     * @param \App\Models\UssdVars $ussdVars
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUssdVarsRequest $request, UssdVars $ussdVars)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UssdVars $ussdVars
     * @return \Illuminate\Http\Response
     */
    public function destroy(UssdVars $ussdVars)
    {
        //
    }
}
