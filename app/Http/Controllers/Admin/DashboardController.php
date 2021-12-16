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
    public function __construct(DashboardRepository $dashboard) {
        $this->dashboard = $dashboard;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Application
     */
    public function index(): View|Application {
        $data = $this->dashboard->statistics();

        return view('admin.index', compact('data'));
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
    public function statistics(): array {
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
}
