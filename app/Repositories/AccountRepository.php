<?php


namespace App\Repositories;

use App\Model\Account;
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

        return $acc;

    }

    public function create(array $acc): Account
    {
        $phone = ltrim(PhoneNumber::make($acc['phone'], 'KE')->formatE164(), '+');

        $referral = (new ReferralRepository)->findByPhone($phone);

        $acc = $this->wherePhone($phone)->first();

        if ($acc)
            return $acc;

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

        return $acc;

    }

    public function getReferrer(Account $account, $level): Account
    {
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
        $max_level = 6;

        $level = $level > $max_level ? $max_level : $level;

//        TODO: try get specific depth then use path to get user ids for earnings module possibly
        if (!$withAccount)
            return $account->ancestors()->whereDepth('>=', -$level)->get();

        $account['level_referrers'] = $account->ancestors()->whereDepth('>=', -$level)->get();

        return $account;
    }

}