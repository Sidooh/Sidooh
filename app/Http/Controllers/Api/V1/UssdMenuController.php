<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UssdMenu;
use Illuminate\Http\Request;

class UssdMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return UssdMenu::all();
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
        return UssdMenu::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UssdMenu $ussdMenu
     * @return \Illuminate\Http\Response
     */
    public function show(UssdMenu $ussdMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\UssdMenu $ussdMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(UssdMenu $ussdMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UssdMenu $ussdMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UssdMenu $ussdMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UssdMenu $ussdMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(UssdMenu $ussdMenu)
    {
        //
    }
}
