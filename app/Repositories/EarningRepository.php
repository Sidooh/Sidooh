<?php


namespace App\Repositories;

use App\Model\Earning;
use App\Model\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

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
        Log::info('------------------------ Calc Earnings ' . now() . ' ---------------------- ');

        $acc = $transaction->account;

        $groupEarnings = $earnings * .75;

        if ($transaction->amount >= 20) {

            if ($acc->isRoot()) {
                $e = Earning::create([
                    'account_id' => $acc->id,
                    'transaction_id' => $transaction->id,
                    'earnings' => $groupEarnings
                ]);
            } else {
                $referrals = (new AccountRepository)->nth_level_referrers($acc, 6, false);

                $userEarnings = $groupEarnings / (count($referrals) + 1);

                $now = Carbon::now('utc')->toDateTimeString();

                $earnings = array(
                    [
                        'account_id' => $acc->id,
                        'transaction_id' => $transaction->id,
                        'earnings' => $userEarnings,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );

                foreach ($referrals as $referral) {
                    array_push($earnings, [
                        'account_id' => $referral->id,
                        'transaction_id' => $transaction->id,
                        'earnings' => $userEarnings,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }

                $e = Earning::insert($earnings);

            }

            $transaction->status = 'completed';
            $transaction->save();

        }

    }

//    public function store(Request $request): Account
//    {
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
//        return $acc;
//
//    }
//
//    public function create(array $acc): Account
//    {
//        $phone = ltrim(PhoneNumber::make($acc['phone'], 'KE')->formatE164(), '+');
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
//        return $acc;
//
//    }
//
//    public function getReferrer(Account $account, $level): Account
//    {
//        if ($level)
//            return $this->nth_level_referrers($account, $level);
//
//        return $account->referrer ?? abort(404, "No referrer found for this account.");
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param Account $account
//     * @return Account
//     */
//    public function nth_level_referrers(Account $account, $level = 1, $withAccount = true)
//    {
//        //
//        $max_level = 6;
//
//        $level = $level > $max_level ? $max_level : $level;
//
////        TODO: try get specific depth then use path to get user ids for earnings module possibly
//        if (!$withAccount)
//            return $account->ancestors()->whereDepth('>=', -$level)->get();
//
//        $account['level_referrers'] = $account->ancestors()->whereDepth('>=', -$level)->get();
//
//        return $account;
//    }


}