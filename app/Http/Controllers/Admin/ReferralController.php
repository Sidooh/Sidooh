<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReferralStoreRequest;
use App\Http\Resources\ReferralResource;
use App\Models\Referral;
use App\Repositories\ReferralRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReferralController extends Controller
{
    protected $referral;

    /**
     * ReferralController constructor.
     *
     * @param ReferralRepository $referral
     */
    public function __construct(ReferralRepository $referral)
    {
        $this->referral = $referral;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $referrals = $this->referral->latest()->get();
//
        return view('admin.crud.referrals.index', compact('referrals'));
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
     * @param ReferralStoreRequest $request
     * @return ReferralResource
     */
    public function store(ReferralStoreRequest $request)
    {
        //
        return new ReferralResource($this->referral->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return ReferralResource
     */
    public function show(Referral $referral)
    {
//        //
//        Log::info($referral->parent);
////        Log::info($referral->parentAndSelf);
//        $referral['level_' . '1' . '_ancestors'] = $referral->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($referral->ancestors);
////        Log::info($referral->ancestorsAndSelf);
//        Log::info($referral->siblings);
////        Log::info($referral->siblingsAndSelf);
//        Log::info($referral->children);
////        Log::info($referral->childrenAndSelf);
//        Log::info($referral->descendants);
////        Log::info($referral->descendantsAndSelf);

        return new ReferralResource($referral);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Referral $referral
     * @return Response
     */
    public function edit(Referral $referral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Referral $referral
     * @return Response
     */
    public function update(Request $request, Referral $referral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Referral $referral
     * @return Response
     */
    public function destroy(Referral $referral)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return ReferralResource
     */
    public function referrals(Referral $referral)
    {
        //
        return new ReferralResource($this->referral->with(['pending_referrals', 'active_referrals'])->find($referral->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Referral $referral
     * @return ReferralResource
     */
    public function referrer(Request $request, Referral $referral)
    {
        //

        return new ReferralResource($this->referral->getReferrer($referral, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return ReferralResource
     */
    public function subscriptions(Referral $referral)
    {
        //
        return new ReferralResource($this->referral->with(['active_subscription'])->find($referral->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return ReferralResource
     */
    public function vouchers(Referral $referral)
    {
        //
        return new ReferralResource($referral->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return ReferralResource
     */
    public function earnings(Referral $referral)
    {
        //
        return new ReferralResource($this->referral->earningsSummary($referral->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return ReferralResource
     */
    public function earningsReport(Referral $referral)
    {
        //

        return $this->referral->earningsReport($referral->phone);
        return new ReferralResource($this->referral->earningsReport($referral->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Referral $referral
//     * @return ReferralResource
//     */
    public function subReferrals(Referral $referral)
    {
        //
        return new ReferralResource($this->referral->invest());
    }

}
