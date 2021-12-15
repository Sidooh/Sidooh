<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $user;

    /**
     * AccountController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function index()
    {
        //
        $users = $this->user->latest()->get();

        return view('admin.crud.users.index', compact('users'));
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
    public function earnings(Account $account)
    {
        //
        return new AccountResource($this->account->earningsSummary($account->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return AccountResource
     */
    public function earningsReport(Account $account)
    {
        //

        return $this->account->earningsReport($account->phone);
        return new AccountResource($this->account->earningsReport($account->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Account $account
//     * @return AccountResource
//     */
    public function subAccounts(Account $account)
    {
        //
        return new AccountResource($this->account->invest());
    }

}
