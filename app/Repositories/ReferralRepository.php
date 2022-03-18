<?php


namespace App\Repositories;

use App\Models\Referral;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * App\Repositories\ReferralRepository
 *
 * @property int $id
 * @property int $referee_phone
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $referee_id
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereRefereeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereRefereePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereUpdatedAt($value)
 * @mixin IdeHelperReferralRepository
 */
class ReferralRepository extends Model
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
        $this->model = app(Referral::class);
    }

    public function store(array $request): Referral
    {
//        TODO: Schedule every hour/30 mins?
        $this->removeExpiredReferrals();

        if (array_key_exists('account_id', $request))
            $acc = (int)$request['account_id'];
        else {
            $acc = AccountRepository::firstOrCreate(['phone' => $request['phone']])->id;
        }

        $arr = [
            'referee_phone' => $request['referee_phone'],
            'account_id' => $acc
        ];

        Log::info($arr);

        return $this->create($arr);

    }

    public function validatePhone(string $phoneNumber, $throw = false)
    {
        $country = null;

        if (substr($phoneNumber, 0, 1) !== '+')
            $phoneNumber = '+' . $phoneNumber;

        try {
            $country = PhoneNumber::make($phoneNumber)->getCountry();
        } catch (NumberParseException $e) {
            Log::info($e);

            if ($throw)
                throw $e;
        }

        return $country ? true : false;
    }

    public function findByPhone(string $phoneNumber, $throw = False): ?Referral
    {
        $valid = $this->validatePhone($phoneNumber, $throw);

        return !$valid ? abort(422, 'Phone seems to be invalid.') :

            $this->timeActive()
                ->whereRefereePhone($phoneNumber)
                ->first();
    }

    public function checkReferral(int $id): Referral
    {
        return $this->findorFail($id);
    }

    public function removeExpiredReferrals()
    {
        $refs = $this->expired()->delete();

//        Log::info($refs);
    }
}
