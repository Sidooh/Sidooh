<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        //
        $accounts = $this->account->latest()->get();

        return view('admin.crud.accounts.index', compact('accounts'));
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
        $account->load(['user', 'referrer', 'sub_accounts', 'voucher']);
        $this->account->nth_level_referrals($account, 5);

        $data = $this->account->statistics($account);

        return view('admin.crud.accounts.show', compact('account', 'data'));
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

    public function topupVoucher(Account $account, Request $request)
    {
        $transaction = new Transaction();

        $transaction->amount = $request->amount;
        $transaction->type = 'PAYMENT';
        $transaction->description = 'Voucher Purchase - Admin';
        $transaction->account_id = $account->id;
        $transaction->product_id = 3;

        $transaction->save();

        $voucherDetails = [
            'phone' => $account->phone,
            'amount' => $transaction->amount
        ];

        (new ProductRepository())->voucher($transaction, $voucherDetails);

        return back();
    }

}
