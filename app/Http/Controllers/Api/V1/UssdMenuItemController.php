<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UssdMenuItem;
use Illuminate\Http\Request;

class UssdMenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return UssdMenuItem::all();
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
     * @param \App\Models\UssdMenuItems $ussdMenuItems
     * @return \Illuminate\Http\Response
     */
    public function show(UssdMenuItems $ussdMenuItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\UssdMenuItems $ussdMenuItems
     * @return \Illuminate\Http\Response
     */
    public function edit(UssdMenuItems $ussdMenuItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UssdMenuItems $ussdMenuItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UssdMenuItems $ussdMenuItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UssdMenuItems $ussdMenuItems
     * @return \Illuminate\Http\Response
     */
    public function destroy(UssdMenuItems $ussdMenuItems)
    {
        //
    }
}
