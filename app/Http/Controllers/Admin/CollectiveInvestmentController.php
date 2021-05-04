<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectiveInvestmentStoreRequest;
use App\Http\Resources\CollectiveInvestmentResource;
use App\Models\CollectiveInvestment;
use App\Repositories\CollectiveInvestmentRepository;
use App\Repositories\InvestmentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectiveInvestmentController extends Controller
{
    protected $collectiveInvestment;

    /**
     * CollectiveInvestmentController constructor.
     *
     * @param InvestmentRepository $collectiveInvestment
     */
    public function __construct(InvestmentRepository $collectiveInvestment)
    {
        $this->collectiveInvestment = $collectiveInvestment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $collectiveInvestments = $this->collectiveInvestment->latest()->get();

        return view('admin.crud.collective_investments.index', compact('collectiveInvestments'));
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
     * @param CollectiveInvestmentStoreRequest $request
     * @return CollectiveInvestmentResource
     */
    public function store(CollectiveInvestmentStoreRequest $request)
    {
        //
        return new CollectiveInvestmentResource($this->collectiveInvestment->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param CollectiveInvestment $collectiveInvestment
     * @return CollectiveInvestmentResource
     */
    public function show(CollectiveInvestment $collectiveInvestment)
    {
//        //
//        Log::info($collectiveInvestment->parent);
////        Log::info($collectiveInvestment->parentAndSelf);
//        $collectiveInvestment['level_' . '1' . '_ancestors'] = $collectiveInvestment->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($collectiveInvestment->ancestors);
////        Log::info($collectiveInvestment->ancestorsAndSelf);
//        Log::info($collectiveInvestment->siblings);
////        Log::info($collectiveInvestment->siblingsAndSelf);
//        Log::info($collectiveInvestment->children);
////        Log::info($collectiveInvestment->childrenAndSelf);
//        Log::info($collectiveInvestment->descendants);
////        Log::info($collectiveInvestment->descendantsAndSelf);
///

        $collectiveInvestment->load(['user', 'referrer', 'sub_collectiveInvestments', 'voucher']);
        $this->collectiveInvestment->nth_level_referrals($collectiveInvestment, 5);

        $data = $this->collectiveInvestment->statistics($collectiveInvestment);

        return view('admin.crud.collectiveInvestments.show', compact('collectiveInvestment', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CollectiveInvestment $collectiveInvestment
     * @return Response
     */
    public function edit(CollectiveInvestment $collectiveInvestment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CollectiveInvestment $collectiveInvestment
     * @return Response
     */
    public function update(Request $request, CollectiveInvestment $collectiveInvestment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CollectiveInvestment $collectiveInvestment
     * @return Response
     */
    public function destroy(CollectiveInvestment $collectiveInvestment)
    {
        //
    }


//    /**
//     * Display the specified resource.
//     *
//     * @param CollectiveInvestment $collectiveInvestment
//     * @return CollectiveInvestmentResource
//     */
    public function subInvestments(Request $request, CollectiveInvestment $collectiveInvestment)
    {
        //
        $subInvestments = $collectiveInvestment->subInvestments;

        return view('admin.crud.sub_investments.index', compact('subInvestments'));
    }

}
