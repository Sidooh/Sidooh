<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubInvestmentStoreRequest;
use App\Http\Resources\SubInvestmentResource;
use App\Models\SubInvestment;
use App\Repositories\SubInvestmentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubInvestmentController extends Controller
{
    protected $subInvestment;

    /**
     * SubInvestmentController constructor.
     *
     * @param SubInvestmentRepository $subInvestment
     */
    public function __construct(SubInvestmentRepository $subInvestment)
    {
        $this->subInvestment = $subInvestment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $subInvestments = $this->subInvestment->latest()->get();

        return view('admin.crud.sub_investments.index', compact('subInvestments'));
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
     * @param SubInvestmentStoreRequest $request
     * @return SubInvestmentResource
     */
    public function store(SubInvestmentStoreRequest $request)
    {
        //
        return new SubInvestmentResource($this->subInvestment->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function show(SubInvestment $subInvestment)
    {
//        //
//        Log::info($subInvestment->parent);
////        Log::info($subInvestment->parentAndSelf);
//        $subInvestment['level_' . '1' . '_ancestors'] = $subInvestment->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($subInvestment->ancestors);
////        Log::info($subInvestment->ancestorsAndSelf);
//        Log::info($subInvestment->siblings);
////        Log::info($subInvestment->siblingsAndSelf);
//        Log::info($subInvestment->children);
////        Log::info($subInvestment->childrenAndSelf);
//        Log::info($subInvestment->descendants);
////        Log::info($subInvestment->descendantsAndSelf);
///

        $subInvestment->load(['user', 'referrer', 'sub_subInvestments', 'voucher']);
        $this->subInvestment->nth_level_referrals($subInvestment, 5);

        $data = $this->subInvestment->statistics($subInvestment);

        return view('admin.crud.subInvestments.show', compact('subInvestment', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return Response
     */
    public function edit(SubInvestment $subInvestment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SubInvestment $subInvestment
     * @return Response
     */
    public function update(Request $request, SubInvestment $subInvestment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubInvestment $subInvestment
     * @return Response
     */
    public function destroy(SubInvestment $subInvestment)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function referrals(SubInvestment $subInvestment)
    {
        //
        return new SubInvestmentResource($this->subInvestment->with(['pending_referrals', 'active_referrals'])->find($subInvestment->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function referrer(Request $request, SubInvestment $subInvestment)
    {
        //

        return new SubInvestmentResource($this->subInvestment->getReferrer($subInvestment, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function subscriptions(SubInvestment $subInvestment)
    {
        //
        return new SubInvestmentResource($this->subInvestment->with(['active_subscription'])->find($subInvestment->id));
    }

    /**
     * Display the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function vouchers(SubInvestment $subInvestment)
    {
        //
        return new SubInvestmentResource($subInvestment->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function earnings(SubInvestment $subInvestment)
    {
        //
        return new SubInvestmentResource($this->subInvestment->earningsSummary($subInvestment->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param SubInvestment $subInvestment
     * @return SubInvestmentResource
     */
    public function earningsReport(SubInvestment $subInvestment)
    {
        //

        return $this->subInvestment->earningsReport($subInvestment->phone);
        return new SubInvestmentResource($this->subInvestment->earningsReport($subInvestment->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param SubInvestment $subInvestment
//     * @return SubInvestmentResource
//     */
    public function subSubInvestments(SubInvestment $subInvestment)
    {
        //
        return new SubInvestmentResource($this->subInvestment->invest());
    }

}
