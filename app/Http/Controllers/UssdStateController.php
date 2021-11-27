<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUssdStateRequest;
use App\Http\Requests\UpdateUssdStateRequest;
use App\Models\UssdState;

class UssdStateController extends Controller
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
     * @param \App\Http\Requests\StoreUssdStateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUssdStateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Http\Response
     */
    public function show(UssdState $ussdState)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Http\Response
     */
    public function edit(UssdState $ussdState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUssdStateRequest $request
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUssdStateRequest $request, UssdState $ussdState)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Http\Response
     */
    public function destroy(UssdState $ussdState)
    {
        //
    }
}
