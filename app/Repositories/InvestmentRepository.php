<?php


namespace App\Repositories;


use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Models\Account;
use App\Models\CollectiveInvestment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

class InvestmentRepository extends Model
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
        $this->model = app(CollectiveInvestment::class);
    }

    public function invest()
    {
        $accounts = $this->model->with(['sub_accounts' => function ($q) {
            $q->where('in', '>', 'out')->whereIn('type', ['CURRENT', 'SAVINGS']);
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
//        $cInvestment->maturity_date = Carbon::now()->addMonth();

        foreach ($cInvestment->subInvestments as $investment) {
            $investment->interest = $investment->amount * ($dayRate / 100);
            $investment->save();
        }

        $cInvestment->save();

        return $cInvestment;
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

    public function allocateInterest()
    {
//        TODO: Will be done every month for those investments that have matured...
        $accs = Account::all();

        DB::beginTransaction();

        try {
            foreach ($accs as $acc) {
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

            }

            try {
                (new AfricasTalkingApi())->sms(['254714611696', '254711414987'], "STATUS:INVESTMENT\nAllocating Interest.");
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            Log::error($e);
            throw $e;
        }

        DB::commit();
    }

}
