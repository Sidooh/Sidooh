<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    protected $accountRep;

    /**
     * AccountController constructor.
     *
     * @param AccountRepository $account
     */
    public function __construct(AccountRepository $accountRep)
    {
        parent::__construct();
        $this->accountRep = $accountRep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
//        return new AccountResource($this->account->all());
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
     * @param AccountStoreRequest $request
     * @return AccountResource
     */
    public function store(AccountStoreRequest $request)
    {
        //
//        return new AccountResource($this->account->store($request));
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
     * @return Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Account $account
     * @return Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $account
     * @return Response
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
        return new AccountResource($this->account->with(['pending_referrals', 'active_referrals'])->find($account->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Account $account
     * @return AccountResource
     */
    public function referrer(Request $request, Account $account)
    {
        //

        return new AccountResource($this->account->getReferrer($account, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return AccountResource
     */
    public function subscriptions(Account $account)
    {
        //
        return new AccountResource($this->account->with(['active_subscription'])->find($account->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return AccountResource
     */
    public function vouchers(Account $account)
    {
        //
        return new AccountResource($account->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return AccountResource
     */
    public function earnings()
    {
        //
        return new AccountResource($this->accountRep->earningsSummary($this->account->phone));
    }


    public function balances()
    {
        //
        $this->account->load(['sub_accounts', 'voucher']);
//        $this->account->nth_level_referrals($account, 5);
//
//        $data = $this->account->statistics($account);
//
//        return view('admin.crud.accounts.show', compact('account', 'data'));
//
        return new AccountResource($this->account);
    }

}
