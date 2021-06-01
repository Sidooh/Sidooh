<?php


namespace App\Repositories;

use App\Events\ReferralJoinedEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Helpers\Sidooh\Report;
use App\Models\Account;
use App\Models\CollectiveInvestment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\PhoneNumber;

class AccountRepository extends Model
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

    public function store(Request $request): Account
    {
        $phone = ltrim(PhoneNumber::make($request['phone'], 'KE')->formatE164(), '+');

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
        }

        (new SubAccountRepository)->store($acc, 'CURRENT');
        (new SubAccountRepository)->store($acc, 'SAVINGS');
        (new SubAccountRepository)->store($acc, 'INTEREST');

        return $acc;

    }

    public function create(array $acc): Account
    {
//        error_log('-------------------');
//        error_log($acc['phone']);
//        error_log('-------------------');

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

        try {
            (new AfricasTalkingApi())->sms(['254711414987'], "STATUS:INVESTMENT\nCalculating Interest.");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }


//        TODO: To be removed after testing auto assignment
        return $this->calculateInterest(9);


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
//        TODO: Will be done every month for those investments that have matured...
        Log::info('----------------- Interest Allocation');

        $accs = Account::with(['current_account', 'savings_account', 'interest_account'])->get();
        $allocated = collect();
        Log::info(count($accs) . ' accounts to be allocated.');

//        DB::beginTransaction();

        try {
            $counter = 0;
            foreach ($accs as $acc) {
                if ($acc->interest_account && $acc->interest_account->balance > 0) {
                    Log::info($acc->id . ' -> ' . $acc->interest_account->balance);
                    $interest = $acc->interest_account->balance;

//            1. Add 20% to current account
//            2. Add 80% to savings account
//            3. Minus amount from interest account
                    $acc->current_account->in += .2 * $interest;
                    $acc->savings_account->in += .8 * $interest;
                    $acc->interest_account->out += $interest;

                    $acc->current_account->save();
                    $acc->savings_account->save();
                    $acc->interest_account->save();

                    $counter++;
                    $allocated->add($acc);
                }
            }

        } catch (\Exception $e) {
            //failed logic here
//            DB::rollback();
            Log::error($e);
            throw $e;
        }
        Log::info('Update completed.');

//        DB::commit();

        if (count($allocated) > 0) {
            Log::info('Sending sms.');

            try {
                (new AfricasTalkingApi())->sms(['254714611696', '254711414987'], "STATUS:INVESTMENT\nAllocating Interest. $counter accounts updated.");
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

        }

        Log::info('Completed.');

        return $allocated;
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
