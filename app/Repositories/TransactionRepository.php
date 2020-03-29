<?php


namespace App\Repositories;

use App\Events\TransactionSuccessEvent;
use App\Model\Transaction;
use App\Models\AirtimeResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

class TransactionRepository extends Model
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
        $this->model = app(Transaction::class);
    }

    public function statusUpdate(AirtimeResponse $airtime_response)
    {
        Log::info('------------------------ Transaction Status Update ' . now() . ' ---------------------- ');

        $airtime_request = $airtime_response->request;

        $responses = $airtime_request->responses;

//        TODO:: Remove Sent from successful
        $successful = $responses->filter(function ($value, $key) {
            return $value->status == 'Success' || $value->status == 'Sent';
        });

        if (count($successful) == count($responses)) {

            $transaction = $airtime_request->transaction;

            $transaction->status = 'success';

            $transaction->save();

            $totalEarned = explode(" ", $airtime_request->totalDiscount)[1];

            event(new TransactionSuccessEvent($transaction, $totalEarned));
        }

    }

    public function updateToSuccess(Transaction $transaction)
    {
        $transaction->status = 'success';

        $transaction->save();
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