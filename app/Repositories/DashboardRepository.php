<?php


namespace App\Repositories;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\UssdLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

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
    public function __construct() {
        $this->model = app(Account::class);
    }

    public function statistics(): array {
//        2nd: Get total customers, Transactions, Revenue
        $totalAccounts = Account::count();
        $totalAccountsToday = Account::whereDate('created_at', Carbon::today())->count();

//        Do the exact same for transactions and revenue
        $totalTransactions = Transaction::count();
        $totalTransactionsToday = Transaction::whereDate('created_at', Carbon::today())->count();


//        and revenue is slightly different
//        TODO: Need to standardize transaction statuses
        $transactions = Transaction::whereStatus(['completed', 'success'])->whereType('PAYMENT')->get();

        $totalRevenue = $transactions->sum('amount');
        $totalRevenueToday = $transactions->filter(fn($item) => $item->created_at->isToday())->sum('amount');

//        Try and get only specific fields...
        $transactions = Transaction::whereType('PAYMENT')
            ->with([
                'account' => function($query) {
                    return $query->select(['id', 'phone', 'user_id'])->with(['user:id,name']);
                }
            ])
            ->with([
                'payment' => function($query) {
                    return $query->select(['payable_id', 'status']);
                }
            ])
            ->select(['id', 'description', 'account_id', 'amount', 'status', 'updated_at'])
            ->latest()
            ->limit(16)
            ->get();


        $pendingTransactions = Transaction::whereType('PAYMENT')
            ->with([
                'account' => function($query) {
                    return $query->select(['id', 'phone', 'user_id'])->with(['user:id,name']);
                }
            ])
            ->with([
                'payment' => function($query) {
                    return $query->select(['payable_id', /*'payable_type',*/ 'status']);
                }
            ])
            ->select(['id', 'description', 'account_id', 'amount', 'status', 'updated_at'])
            ->latest()
            ->whereStatus('pending')
            ->get();

//        4th: Get current active users
        $usersToday = UssdLog::whereDate('updated_at', Carbon::today())->distinct()->count('phone');

        return [
            'totalAccountsToday' => $totalAccountsToday,
            'totalAccounts'      => $totalAccounts,

            'totalTransactionsToday' => $totalTransactionsToday,
            'totalTransactions'      => $totalTransactions,

            'totalRevenueToday' => $totalRevenueToday,
            'totalRevenue'      => $totalRevenue,

            'recentTransactions'  => $transactions,
            'pendingTransactions' => $pendingTransactions,

            'totalUsersToday' => $usersToday,
        ];
    }
}
