<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\UssdLog;
use App\Repositories\DashboardRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;

class DashboardController extends Controller
{
    protected DashboardRepository $dashboard;

    /**
     * DashboardController constructor.
     *
     * @param DashboardRepository $dashboard
     */
    public function __construct(DashboardRepository $dashboard)
    {
        $this->dashboard = $dashboard;

        $this->factory();
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Application
     */
    public function index(): View|Application
    {
        $data['data'] = $this->dashboard->statistics();

        return view('admin.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Application
     */
    public function analytics(): View|Application
    {
        return view('admin.analytics', []);
    }

    #[ArrayShape([
        'totalToday'             => "int|mixed",
        'totalYesterday'         => "int|mixed",
        'totalAccountsToday'     => "int",
        'totalAccounts'          => "int",
        'totalTransactionsToday' => "int",
        'totalTransactions'      => "int",
        'totalRevenueToday'      => "mixed",
        'totalRevenue'           => "mixed",
        'totalUsersToday'        => "int"
    ])]
    public function statistics(): array
    {
        //        2nd: Get total customers, Transactions, Revenue
        $totalAccounts = Account::count();
        $totalAccountsToday = Account::whereDate('created_at', Carbon::today())->count();

//        Do the exact same for transactions and revenue
        $totalTransactions = Transaction::count();
        $totalTransactionsToday = Transaction::whereDate('created_at', Carbon::today())->count();

        //        TODO: Need to standardize transaction statuses
        $transactions = Transaction::whereStatus('completed')->whereType('PAYMENT')->get();

        $totalRevenue = $transactions->sum('amount');
        $totalRevenueToday = $transactions->filter(fn($item) => $item->created_at->isToday())->sum('amount');

        //        4th: Get current active users
        $usersToday = UssdLog::whereDate('updated_at', Carbon::today())->distinct()->count('phone');

//        TODO: Get all transactions after yesterday, then filter yesterday and today in code
        return [
            'totalToday'     => Transaction::whereStatus('completed')
                ->whereDate('created_at', Carbon::today())
                ->sum('amount'),
            'totalYesterday' => Transaction::whereStatus('completed')
                ->whereDate('created_at', Carbon::yesterday())
                ->sum('amount'),

            'totalAccountsToday' => $totalAccountsToday,
            'totalAccounts'      => $totalAccounts,

            'totalTransactionsToday' => $totalTransactionsToday,
            'totalTransactions'      => $totalTransactions,

            'totalRevenueToday' => $totalRevenueToday,
            'totalRevenue'      => $totalRevenue,

            'totalUsersToday' => $usersToday,
        ];
    }


    public function factory()
    {
        /**_________________________________    ACCOUNTS FACTORY
         */
//        $accounts = Account::get()->map(fn($accounts) => [
//            ...$accounts->toArray(),
//            "created_at" => now()->endOfDay()->subDays(mt_rand(0, 30)),
//            "updated_at" => $accounts->updated_at
//        ])->toArray();
//
//        Account::upsert($accounts, ["id"], ["created_at"]);

//        dd($accounts);

        /**_________________________________    TRANSACTIONS FACTORY
         */
//        $transactions = Transaction::limit(mt_rand(70, 130))->get()->map(fn($transaction) => [
//            ...$transaction->toArray(),
//            "created_at" => Carbon::now()->subHours(mt_rand(0, 24)),
//            "updated_at" => $transaction->updated_at
//        ])->toArray();
//
//        Transaction::upsert($transactions, ["id"], ["created_at"]);

//        dd($transactions);
    }
}
