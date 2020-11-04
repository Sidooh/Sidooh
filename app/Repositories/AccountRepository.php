<?php


namespace App\Repositories;

use App\Events\ReferralJoinedEvent;
use App\Helpers\Sidooh\Report;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

        return $acc;

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

        (new SubAccountRepository)->store($acc, 'CURRENT');
        (new SubAccountRepository)->store($acc, 'SAVINGS');

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
                $sub = $item->active_subscription->last();

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
                $sub = $item->active_subscription->last();

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

}
