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

class DashboardRepository extends Model
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

        $totalToday = $status['Complete']->reduce(function ($carry, $item) {
            return $carry + $item->amount;
        });

        $totalYesterday = Payment::whereDate('created_at', Carbon::yesterday())->whereStatus('Complete')->sum('amount');

        $todaySuccesfulPayments = $status['Complete']->groupBy(function($item) {
            return Carbon::parse($item->updated_at)->format('h:00');
        });
//        if you wish to sum afterwards
        $todaySuccesfulPayments = $todaySuccesfulPayments->mapWithKeys(function ($group, $key) {
            return [
                $key =>
                    [
                        'time' => $key, // $key is what we grouped by, it'll be constant by each  group of rows
                        'total' => $group->sum('amount'),
                        'count' => $group->count(),
                    ]
            ];
        });

//        Can then do the same for failed and all payments
//        Maybe we should create functions that we can them map to either...
//        Should change the status to have all except complete
        $todayFailedPayments = $status['Pending']->groupBy(function($item) {
            return Carbon::parse($item->updated_at)->format('h:00');
        });
//        if you wish to sum afterwards
        $todayFailedPayments = $todayFailedPayments->mapWithKeys(function ($group, $key) {
            return [
                $key =>
                    [
                        'time' => $key, // $key is what we grouped by, it'll be constant by each  group of rows
                        'total' => $group->sum('amount'),
                        'count' => $group->count(),
                    ]
            ];
        });


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
        $totalRevenueToday = $transactions->filter(fn ($item) => $item->created_at->isToday())->sum('amount');
        $totalRevenueWeek = $transactions->filter(fn ($item) => $item->created_at->isCurrentWeek())->sum('amount');
        $totalRevenueMonth = $transactions->filter(fn ($item) => $item->created_at->isCurrentMonth())->sum('amount');

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
            ->with(['account' => function($query) {
                return $query->select(['id', 'phone', 'user_id'])
                    ->with(['user:id,name']);
            }])
            ->with(['payment' => function($query) {
                return $query->select(['payable_id', /*'payable_type',*/ 'status']);
            }])
            ->select(['id', 'description', 'account_id'])
            ->limit(8)
            ->get();


//        return [
//            'recentTransactions' => $transactions
//        ];

//        4th: Get current active users

        $usersLastHour = UssdLog::whereDate('updated_at', '>', Carbon::now()->subHour())->count();

//        return [
//            'activeUsersLastHour' => $usersLastHour
//        ];


        return [
            'totalToday' => $totalToday,
            'totalYesterday' => $totalYesterday,
            'successfulPayments' => $todaySuccesfulPayments,
            'failedPayments' => $todayFailedPayments,

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

            'activeUsersLastHour' => $usersLastHour,
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
    public function create(array $acc): Account
    {
        error_log('-------------------');
        error_log($acc['phone']);
        error_log('-------------------');

        $phone = ltrim(PhoneNumber::make($acc['phone'], 'KE')->formatE164(), '+');

        $acc = $this->wherePhone($phone)->first();

        if ($acc)
            return $acc;

        $referral = (new ReferralRepository)->findByPhone($phone);

        $arr = [
            'telco_id' => 1,
            'phone' => $phone,
            'referrer_id' => $referral ? $referral->account_id : null
        ];

        $acc = $this->firstOrCreate($arr);

        if ($referral) {
            $referral->referee_id = $acc->id;
            $referral->status = 'active';

            $referral->save();

            event(new ReferralJoinedEvent($referral));
        }

        (new VoucherRepository)->storeOrCreate($arr);

        (new SubAccountRepository)->store($acc, 'CURRENT');
        (new SubAccountRepository)->store($acc, 'SAVINGS');
        (new SubAccountRepository)->store($acc, 'INTEREST');

        return $acc;
    }

    public function getReferrer(Account $account, $level, $subscribed = false): Account
    {
        if ($subscribed)
            return $this->subscribed_nth_level_referrers($account, $level);

        if ($level)
            return $this->nth_level_referrers($account, $level);

        return $account->referrer ?? abort(404, "No referrer found for this account.");
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @param int $level
     * @param bool $withAccount
     * @return Account
     */
    public function nth_level_referrers(Account $account, $level = 1, $withAccount = true)
    {
        //
        $max_level = 5;

        $level = $level > $max_level ? $max_level : $level;

//        TODO: try get specific depth then use path to get user ids for earnings module possibly
        if (!$withAccount)
            return $account->ancestors()->whereDepth('>=', -$level)->get();

        $account['level_referrers'] = $account->ancestors()->whereDepth('>=', -$level)->get();

        return $account;
    }


    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @param int $level
     * @param bool $withAccount
     * @return Account
     */
    public function subscribed_nth_level_referrers(Account $account, $level = 1, $withAccount = true)
    {
        //
        $account_refs = $this->nth_level_referrers($account, $level, $withAccount);

        if (!$withAccount)

            $account = $account_refs->map(function ($item) {
                $depth = abs((int)$item->depth);
                $sub = $item->active_subscription;

                if ($depth == 1)
                    return $item->withoutRelations();

                if ($depth < 3) {

                    if ($sub) {
                        $subtype = $sub->subscription_type;

                        if ($subtype->level_limit == 3)
                            return $item->withoutRelations();

                    }

                }

                if ($depth <= 5) {

                    if ($sub) {
                        $subtype = $sub->subscription_type;

                        if ($subtype->level_limit == 5)
                            return $item->withoutRelations();

                    }

                }

                return null;

            })->filter()->all();

        else

            $account['level_referrers'] = $account_refs->level_referrers->map(function ($item) {
                $depth = abs((int)$item->depth);
                $sub = $item->active_subscription;

                if ($depth == 1)
                    return $item->withoutRelations();

                if ($depth < 3) {

                    if ($sub) {
                        $subtype = $sub->subscription_type;

                        if ($subtype->level_limit == 3)
                            return $item->withoutRelations();

                    }

                }

                if ($depth <= 5) {

                    if ($sub) {
                        $subtype = $sub->subscription_type;

                        if ($subtype->level_limit == 5)
                            return $item->withoutRelations();

                    }

                }

                return null;

            })->filter()->all();

        return $account;

    }

    public function findByPhone($phoneNumber, $throw = true)
    {
        $valid = (new ReferralRepository())->validatePhone($phoneNumber, $throw);

        return !$valid ? abort(422, 'Phone seems to be invalid.') :

            $this->wherePhone($phoneNumber)
                ->first();
    }

    public function earnings(Account $account, $start_date = null)
    {
        $earnings = $start_date != null ? $account->earnings()->where('created_at', '>', $start_date)->get() : $account->earnings;

        return $earnings;

    }

    public function withdrawals(Account $account, $start_date = null)
    {
        $withdrawals = $start_date ? $account->transactions()->whereType('WITHDRAWAL')->where('created_at', '>=', $start_date)->get() : $account->transactions()->whereType('WITHDRAWAL')->get();

        return $withdrawals;

    }

    public function earningsSummary($phoneNumber)
    {
        $acc = $this->findByPhone($phoneNumber);

        //        TODO:: USE ONE QUERY FOR DB THEN COLLECTION FILTER? MORE EFFICIENT?
//        $acc = $this->account->find($account->id);
        $acc['total_earnings'] = $acc->earnings->sum('earnings');

        $acc['self_earnings'] = $acc->earnings()->whereType('SELF')->sum('earnings');
        $acc['referral_earnings'] = $acc->earnings()->whereType('REFERRAL')->sum('earnings');

        return $acc;

    }

    public function earningsReport($phoneNumber)
    {
        return (new Report($phoneNumber))->generateJson();
    }

//    TODO: All these should move to the Investment repository
    public function invest()
    {
//        TODO: Should we use created_at ama invested_at?
        $cInvestment = CollectiveInvestment::whereDate('created_at', Carbon::today())->first();

        if ($cInvestment) {
            return $cInvestment;
        }

        $accounts = $this->model->with(['sub_accounts' => function ($q) {
            $q->where('in', '>', 'out')->whereIn('type', ['CURRENT', 'SAVINGS', 'INTEREST']);
        }])->get();

        $accounts = $accounts->map(function ($item, $key) {
            $item->balance = $item->sub_accounts->reduce(function ($carry, $item) {
                return $carry + $item->balance;
            });
            return $item;
        })->filter(function ($item, $key) {
            return $item->balance > 0;
        });

        $totalAmount = $accounts->reduce(function ($carry, $item) {
            return $carry + $item->balance;
        });

        $cI = CollectiveInvestment::create([
            'amount' => $totalAmount,
        ]);

        foreach ($accounts as $account) {
            $cI->subInvestments()->create([
                'amount' => $account->balance,
                'account_id' => $account->id,
            ]);
        }

        return $cI->subInvestments;
    }

    public function calculateInterest(float $rate)
    {
        $dayRate = $this->getDailyRate($rate);

//       TODO: Should this be in a transaction(db)
        $cInvestment = CollectiveInvestment::whereInterestRate(null)->latest()->first();

        if (!$cInvestment) {
            return 'No Pending Investment';
        }

        $cInvestment->interest_rate = $rate;
        $cInvestment->interest = $cInvestment->amount * ($dayRate / 100);

//        TODO: Will the following be calculated on manual input or should it be automatically 30days?
        $cInvestment->maturity_date = Carbon::now()->addMonth();

        foreach ($cInvestment->subInvestments as $investment) {
            $investment->interest = $investment->amount * ($dayRate / 100);
            $investment->save();

//            TODO: Should this be done here?
            $subAcc = $investment->account->interest_account;
            $subAcc->in += $investment->interest;
            $subAcc->save();
        }

        $cInvestment->save();

        return $cInvestment;
    }

    public function allocateInterest()
    {
//        TODO: Will be done everyday for those investments that have matured...


    }

    public function getDailyRate(float $rate)
    {
//        First, divide the APY by 100 to convert to a decimal.
//        Second, add 1.
//        Third, raise the result to the 1/365th power.
//        Fourth, subtract 1.
//        Fifth, multiply by 100 to find the daily interest rate.

        $rate = (((($rate / 100) + 1) ** (1 / 365)) - 1) * 100;

        return $rate;
    }

}
