<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReferralResource;
use App\Models\Earning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->account->earnings()->get();

        Log::info($data);
        return new ReferralResource($data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function show(Earning $earning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function edit(Earning $earning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Earning $earning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earning $earning)
    {
        //
    }
}
