<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Statistics\ChartAid;
use App\Helpers\Statistics\Frequency;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\UssdLog;
use App\Repositories\DashboardRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    public function index(Request $request): View|Application {
//        Transaction::inRandomOrder()->take(100)->get()->each(function(Transaction $transaction) {
//            $minutes = now()->diffInMinutes(now()->startOfDay());
//
//            $transaction->created_at = now()->subMinutes(mt_rand(0, $minutes));
//            $transaction->save();
//        });

//        dd(Transaction::first()->created_at);

//        $this->statistics($request);

        $data = $this->dashboard->statistics();

        return view('admin.index', compact('data'));
    }

    public function statistics($request): array {
        $frequency = Frequency::tryFrom((string)$request->input('frequency')) ?? Frequency::DAILY;

        $chartAid = new ChartAid($frequency, 'sum', 'amount');

        $yesterday = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            Carbon::yesterday()->startOfDay(),
            Carbon::yesterday()->endOfDay()
        ])->whereStatus('completed')->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $today = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            Carbon::today()->startOfDay()->timezone('Africa/Nairobi'),
            Carbon::today()->endOfDay()->timezone('Africa/Nairobi')
        ])->whereStatus('completed')->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

//        dd($today);

        $todayHrs = now()->diffInHours(now()->startOfDay());
        ['labels' => $labels, 'datasets' => $datasetsYesterday] = $chartAid->chartDataSet($yesterday, 24);
        ['datasets' => $datasetsToday] = $chartAid->chartDataSet($today, $todayHrs);

        //        2nd: Get total customers, Transactions, Revenue
        $totalAccounts = Account::count();
        $totalAccountsToday = Account::whereDate('created_at', Carbon::today())->count();

//        Do the exact same for transactions and revenue
        $totalTransactions = Transaction::count();
        $totalTransactionsToday = Transaction::whereDate('created_at', Carbon::today())->count();

        //        TODO: Need to standardize transaction statuses
        $transactions = Transaction::whereStatus(['completed', 'success'])->whereType('PAYMENT')->get();

        $totalRevenue = $transactions->sum('amount');
        $totalRevenueToday = $transactions->filter(fn($item) => $item->created_at->isToday())->sum('amount');

        //        4th: Get current active users
        $usersToday = UssdLog::whereDate('updated_at', Carbon::today())->distinct()->count('phone');

        return [
            'totalToday'          => Transaction::whereStatus('completed')
                ->whereDate('created_at', Carbon::today())
                ->sum('amount'),
            'totalYesterday'      => Transaction::whereStatus('completed')
                ->whereDate('created_at', Carbon::yesterday())
                ->sum('amount'),

            'totalAccountsToday' => $totalAccountsToday,
            'totalAccounts'        => $totalAccounts,

            'totalTransactionsToday' => $totalTransactionsToday,
            'totalTransactions'      => $totalTransactions,

            'totalRevenueToday' => $totalRevenueToday,
            'totalRevenue'      => $totalRevenue,

            'totalUsersToday' => $usersToday,
        ];
    }
}
