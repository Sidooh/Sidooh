<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubAccountStoreRequest;
use App\Http\Resources\SubAccountResource;
use App\Models\SubAccount;
use App\Repositories\SubAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubAccountController extends Controller
{
    protected $subAccount;

    /**
     * SubAccountController constructor.
     *
     * @param SubAccountRepository $subAccount
     */
    public function __construct(SubAccountRepository $subAccount)
    {
        $this->subAccount = $subAccount;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $subAccounts = $this->subAccount->latest()->get();

        return view('admin.crud.sub_accounts.index', compact('subAccounts'));
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
     * @param SubAccountStoreRequest $request
     * @return SubAccountResource
     */
    public function store(SubAccountStoreRequest $request)
    {
        //
        return new SubAccountResource($this->subAccount->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function show(SubAccount $subAccount)
    {
//        //
//        Log::info($subAccount->parent);
////        Log::info($subAccount->parentAndSelf);
//        $subAccount['level_' . '1' . '_ancestors'] = $subAccount->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($subAccount->ancestors);
////        Log::info($subAccount->ancestorsAndSelf);
//        Log::info($subAccount->siblings);
////        Log::info($subAccount->siblingsAndSelf);
//        Log::info($subAccount->children);
////        Log::info($subAccount->childrenAndSelf);
//        Log::info($subAccount->descendants);
////        Log::info($subAccount->descendantsAndSelf);
///

        $subAccount->load(['user', 'referrer', 'sub_subAccounts', 'voucher']);
        $this->subAccount->nth_level_referrals($subAccount, 5);

        $data = $this->subAccount->statistics($subAccount);

        return view('admin.crud.subAccounts.show', compact('subAccount', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SubAccount $subAccount
     * @return Response
     */
    public function edit(SubAccount $subAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SubAccount $subAccount
     * @return Response
     */
    public function update(Request $request, SubAccount $subAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubAccount $subAccount
     * @return Response
     */
    public function destroy(SubAccount $subAccount)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function referrals(SubAccount $subAccount)
    {
        //
        return new SubAccountResource($this->subAccount->with(['pending_referrals', 'active_referrals'])->find($subAccount->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function referrer(Request $request, SubAccount $subAccount)
    {
        //

        return new SubAccountResource($this->subAccount->getReferrer($subAccount, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function subscriptions(SubAccount $subAccount)
    {
        //
        return new SubAccountResource($this->subAccount->with(['active_subscription'])->find($subAccount->id));
    }

    /**
     * Display the specified resource.
     *
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function vouchers(SubAccount $subAccount)
    {
        //
        return new SubAccountResource($subAccount->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function earnings(SubAccount $subAccount)
    {
        //
        return new SubAccountResource($this->subAccount->earningsSummary($subAccount->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param SubAccount $subAccount
     * @return SubAccountResource
     */
    public function earningsReport(SubAccount $subAccount)
    {
        //

        return $this->subAccount->earningsReport($subAccount->phone);
        return new SubAccountResource($this->subAccount->earningsReport($subAccount->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param SubAccount $subAccount
//     * @return SubAccountResource
//     */
    public function subSubAccounts(SubAccount $subAccount)
    {
        //
        return new SubAccountResource($this->subAccount->invest());
    }

}
