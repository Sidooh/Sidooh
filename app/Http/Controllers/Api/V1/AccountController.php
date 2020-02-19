<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Resources\AccountResource;
use App\Model\Account;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $account;

    /**
     * ReferralController constructor.
     *
     * @param ReferralRepository $account
     */
    public function __construct(AccountRepository $account)
    {
        $this->account = $account;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return new AccountResource($this->account->all());
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
     * @param AccountStoreRequest $request
     * @return AccountResource
     */
    public function store(AccountStoreRequest $request)
    {
        //
        return new AccountResource($this->account->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
        return new AccountResource($account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return AccountResource
     */
    public function referrals(Account $account)
    {
        //
        return new AccountResource($this->account->with(['pendingReferrals', 'activeReferrals'])->find($account->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return AccountResource
     */
    public function referrer(Account $account)
    {
        //
        return new AccountResource($account->referrer);
    }
}
