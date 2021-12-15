<?php


namespace App\Repositories;

use App\Models\Earning;
use App\Models\SubAccount;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

/**
 * @mixin IdeHelperEarningRepository
 */
class EarningRepository extends Model
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
        $this->model = app(Earning::class);
    }

    public function calcEarnings(Transaction $transaction, float $earnings)
    {
        Log::info("----------------- Calc Earnings ($earnings)");

        $acc = $transaction->account;

        $groupEarnings = round($earnings * .75, 4);

        $userEarnings = round($groupEarnings / 6, 4);

        $totalLeftOverEarnings = $groupEarnings;

        if ($transaction->amount >= 20 || $transaction->product_id == 4) {

            if ($acc->isRoot()) {
                $e = Earning::create([
                    'account_id' => $acc->id,
                    'transaction_id' => $transaction->id,
                    'earnings' => $userEarnings,
                    'type' => 'SELF'
                ]);

                $sub_acc = $acc->current_account;
                $sub_acc2 = $acc->savings_account;

                $sub_acc->in += .2 * $userEarnings;
                $sub_acc2->in += .8 * $userEarnings;

                $sub_acc->save();
                $sub_acc2->save();

                $totalLeftOverEarnings -= $userEarnings;

            } else {
                $referrals = (new AccountRepository)->subscribed_nth_level_referrers($acc, 5, false);

                if (count($referrals) + 1 > 6)
                    abort(500);

                $now = Carbon::now('utc')->toDateTimeString();

                $userEarning = array(
                    [
                        'account_id' => $acc->id,
                        'transaction_id' => $transaction->id,
                        'earnings' => $userEarnings,
                        'type' => 'SELF',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );

                $totalLeftOverEarnings -= $userEarnings;

                foreach ($referrals as $referral) {
                    array_push($userEarning, [
                        'account_id' => $referral->id,
                        'transaction_id' => $transaction->id,
                        'earnings' => $userEarnings,
                        'type' => 'REFERRAL',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);

                    $totalLeftOverEarnings -= $userEarnings;
                }

                $e = Earning::insert($userEarning);

                foreach ($userEarning as $ue) {
//                    TODO: Get all accounts at once then filter programmatically
                    $acc = SubAccount::type('CURRENT')->whereAccountId($ue['account_id'])->first();
                    $acc2 = SubAccount::type('SAVINGS')->whereAccountId($ue['account_id'])->first();

//                    Log::info($acc);
//                    Log::info($acc2);

                    $acc->in += .2 * $userEarnings;
                    $acc2->in += .8 * $userEarnings;

                    $acc->save();
                    $acc2->save();
                }

            }

            $now = Carbon::now('utc')->toDateTimeString();

            $systemEarnings = array(
                [
//                    'account_id' => $acc->id,
                    'transaction_id' => $transaction->id,
                    'earnings' => $earnings - $groupEarnings,
                    'type' => 'SYSTEM',
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );

            if ($totalLeftOverEarnings > 0) {
                array_push($systemEarnings, [
//                    'account_id' => $referral->id,
                    'transaction_id' => $transaction->id,
                    'earnings' => $totalLeftOverEarnings,
                    'type' => 'SYSTEM',
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            $e = Earning::insert($systemEarnings);

            $transaction->status = 'completed';
            $transaction->save();

        }

    }

    public function statistics()
    {
        $earnings = Earning::latest()->get();

//        TODO: Make api call than can modify this to a chart on the dashboard

        $totalSelf = $earnings->filter(fn($item) => $item->type == 'SELF')->sum('earnings');
        $totalReferral = $earnings->filter(fn($item) => $item->type == 'REFERRAL')->sum('earnings');
        $totalSystem = $earnings->filter(fn($item) => $item->type == 'SYSTEM')->sum('earnings');

        $todayEarnings = $earnings->filter(fn($item) => $item->created_at->isToday());
        $totalSelfToday = $todayEarnings->filter(fn($item) => $item->type == 'SELF')->sum('earnings');
        $totalReferralToday = $todayEarnings->filter(fn($item) => $item->type == 'REFERRAL')->sum('earnings');
        $totalSystemToday = $todayEarnings->filter(fn($item) => $item->type == 'SYSTEM')->sum('earnings');

        return [
            'totalSelf' => $totalSelf,
            'totalReferral' => $totalReferral,
            'totalSystem' => $totalSystem,

            'totalSelfToday' => $totalSelfToday,
            'totalReferralToday' => $totalReferralToday,
            'totalSystemToday' => $totalSystemToday,

            'recentEarnings' => $earnings->take(20)
        ];
    }
}
