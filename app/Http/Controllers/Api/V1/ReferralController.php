<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReferralStoreRequest;
use App\Http\Resources\ReferralResource;

use App\Models\Account;
use App\Repositories\ReferralRepository;
use Illuminate\Http\Request;

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
        parent::__construct();
        $this->referral = $referral;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ReferralResource
     */
    public function index()
    {
        //
        //        TODO: Should we filter status here or in the frontend? SHoudl we show users failed and pending transactions?
        $data = $this->account->referrals()->get();

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
     * @param ReferralStoreRequest $request
     * @return ReferralResource
     */
    public function store(ReferralStoreRequest $request)
    {
        //
        return new ReferralResource($this->referral->store($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param Referral $referral
     * @return \Illuminate\Http\Response
     */
    public function show(Referral $referral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Referral $referral
     * @return \Illuminate\Http\Response
     */
    public function edit(Referral $referral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Referral $referral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referral $referral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Referral $referral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referral $referral)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $phone
     * @return ReferralResource
     */
    public function byPhone(string $phone)
    {
        //
        return new ReferralResource($this->referral->findByPhone($phone) ?: abort(404, 'No referral found.'));
    }
}
