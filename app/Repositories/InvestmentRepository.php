<?php


namespace App\Repositories;


use App\Models\CollectiveInvestment;
use Illuminate\Database\Eloquent\Model;
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
//        TODO: Will be done everyday for those investments that have matured...
    }

}
