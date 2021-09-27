<?php


namespace App\Repositories;

use App\Events\ReferralJoinedEvent;
use App\Helpers\Sidooh\Report;
use App\Models\Account;
use App\Models\CollectiveInvestment;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\UssdLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\PhoneNumber;

class DashboardRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = app(Account::class);
    }

    public function statistics()
    {

//        1st: Get all payments, split by success or failure (Today) - total and hourly
        $payments = Payment::whereDate('created_at', Carbon::today())->get();

        $status = $payments->mapToGroups(function ($item, $key) {
            return [$item['status'] => $item];
        });

        $totalToday = isset($status['Complete']) ? $status['Complete']->reduce(function ($carry, $item) {
            return $carry + $item->amount;
        }) : 0;

        $totalYesterday = Payment::whereDate('created_at', Carbon::yesterday())->whereStatus('Complete')->sum('amount');

//        $todaySuccesfulPayments = isset($status['Complete']) ? $status['Complete']->groupBy(function ($item) {
//            return Carbon::parse($item->updated_at)->format('h:00');
//        }) : collect();
////        if you wish to sum afterwards
//        $todaySuccesfulPayments = $todaySuccesfulPayments->mapWithKeys(function ($group, $key) {
//            return [
//                $key =>
//                    [
//                        'time' => $key, // $key is what we grouped by, it'll be constant by each  group of rows
//                        'total' => $group->sum('amount'),
//                        'count' => $group->count(),
//                    ]
//            ];
//        });

////        Can then do the same for failed and all payments
////        Maybe we should create functions that we can them map to either...
////        Should change the status to have all except complete
//        $todayFailedPayments = isset($status['Pending']) ? $status['Pending']->groupBy(function ($item) {
//            return Carbon::parse($item->updated_at)->format('h:00');
//        }) : collect();
////        if you wish to sum afterwards
//        $todayFailedPayments = $todayFailedPayments->mapWithKeys(function ($group, $key) {
//            return [
//                $key =>
//                    [
//                        'time' => $key, // $key is what we grouped by, it'll be constant by each  group of rows
//                        'total' => $group->sum('amount'),
//                        'count' => $group->count(),
//                    ]
//            ];
//        });


//        return [
//            'totalToday' => $totalToday,
//            'totalYesterday' => $totalYesterday,
//            'successfulPayments' => $todaySuccesfulPayments,
//            'failedPayments' => $todayFailedPayments
//        ];


//        2nd: Get total customers, Transactions, Revenue
        $totalAccounts = Account::count();

        $totalAccountsToday = Account::whereDate('created_at', Carbon::today())->count();
        $totalAccountsWeek = Account::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $totalAccountsMonth = Account::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();


//        return [
//            'totalAccountsToday' => $totalAccountsToday,
//            'totalAccountsWeek' => $totalAccountsWeek,
//            'totalAccountsMonth' => $totalAccountsMonth,
//            'totalAccounts' => $totalAccounts
//        ];

//        Do the exact same for transactions and revenue
        $totalTransactions = Transaction::count();

        $totalTransactionsToday = Transaction::whereDate('created_at', Carbon::today())->count();
        $totalTransactionsWeek = Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $totalTransactionsMonth = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();


//        return [
//            'totalTransactionsToday' => $totalTransactionsToday,
//            'totalTransactionsWeek' => $totalTransactionsWeek,
//            'totalTransactionsMonth' => $totalTransactionsMonth,
//            'totalTransactions' => $totalTransactions
//        ];

//        and revenue is slightly different
//        TODO: Need to standardize transaction statuses
        $transactions = Transaction::whereStatus(['completed', 'success'])->whereType('PAYMENT')->get();

        $totalRevenue = $transactions->sum('amount');
        $totalRevenueToday = $transactions->filter(fn($item) => $item->created_at->isToday())->sum('amount');
        $totalRevenueWeek = $transactions->filter(fn($item) => $item->created_at->isCurrentWeek())->sum('amount');
        $totalRevenueMonth = $transactions->filter(fn($item) => $item->created_at->isCurrentMonth())->sum('amount');

//        return [
//            'totalRevenueToday' => $totalRevenueToday,
//            'totalRevenueWeek' => $totalRevenueWeek,
//            'totalRevenueMonth' => $totalRevenueMonth,
//            'totalRevenue' => $totalRevenue
//        ];


//        3rd: Get list of recent transactions
        $transactions = Transaction::with(['account.user', 'payment'])->limit(8)->get();

//        Try and get only specific fields...
        $transactions = Transaction::whereType('PAYMENT')
            ->with(['account' => function ($query) {
                return $query->select(['id', 'phone', 'user_id'])
                    ->with(['user:id,name']);
            }])
            ->with(['payment' => function ($query) {
                return $query->select(['payable_id', /*'payable_type',*/ 'status']);
            }])
            ->select(['id', 'description', 'account_id', 'amount', 'status', 'updated_at'])
            ->latest()
            ->limit(16)
            ->get();


        $pendingTransactions = Transaction::whereType('PAYMENT')
            ->with(['account' => function ($query) {
                return $query->select(['id', 'phone', 'user_id'])
                    ->with(['user:id,name']);
            }])
            ->with(['payment' => function ($query) {
                return $query->select(['payable_id', /*'payable_type',*/ 'status']);
            }])
            ->select(['id', 'description', 'account_id', 'amount', 'status', 'updated_at'])
            ->latest()
            ->whereStatus('pending')
            ->get();

//        return [
//            'recentTransactions' => $transactions
//        ];

//        4th: Get current active users

        $usersToday = UssdLog::whereDate('updated_at', Carbon::today())->distinct()->count('phone');

//        TODO: Get all users for the last 3 days and then count for each day and display the trend
//        $usersToday = UssdLog::whereDate('updated_at', Carbon::today())->distinct()->count('phone');

//        return [
//            'activeUsersLastDay' => $usersLastDay
//        ];


        return [
            'totalToday' => $totalToday,
            'totalYesterday' => $totalYesterday,
//            'successfulPayments' => $todaySuccesfulPayments,
//            'failedPayments' => $todayFailedPayments,
//            'totalPayments' => $todayFailedPayments,

            'totalAccountsToday' => $totalAccountsToday,
            'totalAccountsWeek' => $totalAccountsWeek,
            'totalAccountsMonth' => $totalAccountsMonth,
            'totalAccounts' => $totalAccounts,

            'totalTransactionsToday' => $totalTransactionsToday,
            'totalTransactionsWeek' => $totalTransactionsWeek,
            'totalTransactionsMonth' => $totalTransactionsMonth,
            'totalTransactions' => $totalTransactions,

            'totalRevenueToday' => $totalRevenueToday,
            'totalRevenueWeek' => $totalRevenueWeek,
            'totalRevenueMonth' => $totalRevenueMonth,
            'totalRevenue' => $totalRevenue,

            'recentTransactions' => $transactions,
            'pendingTransactions' => $pendingTransactions,

            'totalUsersToday' => $usersToday,
        ];


//        $phone = ltrim(PhoneNumber::make($request['phone'], 'KE')->formatE164(), '+');
//
//        $referral = (new ReferralRepository)->findByPhone($phone);
//
//        $arr = [
//            'telco_id' => 1,
//            'phone' => $phone,
//            'referrer_id' => $referral ? $referral->account_id : null
//        ];
//
//        $acc = $this->firstOrCreate($arr);
//
//        if ($referral) {
//            $referral->referee_id = $acc->id;
//            $referral->status = 'active';
//
//            $referral->save();
//        }
//
//        (new SubAccountRepository)->store($acc, 'CURRENT');
//        (new SubAccountRepository)->store($acc, 'SAVINGS');
//        (new SubAccountRepository)->store($acc, 'INTEREST');
//
//        return $acc;

    }
}
