<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EarningStoreRequest;
use App\Http\Resources\EarningResource;
use App\Models\Earning;
use App\Repositories\EarningRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class EarningController extends Controller
{
    protected $earning;

    /**
     * EarningController constructor.
     *
     * @param EarningRepository $earning
     */
    public function __construct(EarningRepository $earning)
    {
        $this->earning = $earning;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $data = $this->earning->statistics();

        return view('admin.crud.earnings.index', compact('data'));
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
     * @param EarningStoreRequest $request
     * @return EarningResource
     */
    public function store(EarningStoreRequest $request)
    {
        //
        return new EarningResource($this->earning->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Earning $earning
     * @return EarningResource
     */
    public function show(Earning $earning)
    {
        $earning->load(['account']);

        if ($earning->payment->type == 'MPESA')
            $earning->load(['payment.descriptor.response']);

//        return new EarningResource($earning);

        return view('admin.crud.earnings.show', compact('earning'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Earning $earning
     * @return Response
     */
    public function edit(Earning $earning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Earning $earning
     * @return Response
     */
    public function update(Request $request, Earning $earning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Earning $earning
     * @return Response
     */
    public function destroy(Earning $earning)
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
