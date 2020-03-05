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
     * AccountController constructor.
     *
     * @param AccountRepository $account
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
     * @param Account $account
     * @return AccountResource
     */
    public function show(Account $account)
    {
//        //
//        Log::info($account->parent);
////        Log::info($account->parentAndSelf);
//        $account['level_' . '1' . '_ancestors'] = $account->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($account->ancestors);
////        Log::info($account->ancestorsAndSelf);
//        Log::info($account->siblings);
////        Log::info($account->siblingsAndSelf);
//        Log::info($account->children);
////        Log::info($account->childrenAndSelf);
//        Log::info($account->descendants);
////        Log::info($account->descendantsAndSelf);

        return new AccountResource($account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Account $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $account
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
    public function referrer(Request $request, Account $account)
    {
        //

        return new AccountResource($this->account->getReferrer($account, $request->query('level')));
    }
}
