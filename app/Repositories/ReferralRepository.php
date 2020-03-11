<?php


namespace App\Repositories;

use App\Model\Referral;
use App\Models\UssdUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

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

//    /**
//     * Find published products by SKU
//     * @param  {int} $sku
//     * @return {Product}
//     */
//    public function findBySku(int $sku): Product {
//        return $this->whereIsPublished(1)
//            ->whereSku($sku)
//            ->first();
//    }

    public function store(array $request): Referral
    {
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

    public static function ussdProcessor(UssdUser $user, array $result, $message)
    {
        if ($user->session == 1 && count($result) > 1) {

            try {
                Log::info(ReferralRepository::validatePhone($message));

                if (ReferralRepository::validatePhone($message)) {
                    $acc = AccountRepository::wherePhone($message)->first();

                    $ref = (new ReferralRepository())->timeActive()
                        ->whereRefereePhone($message)
                        ->first();

                    if ($acc == null && $ref == null) {
                        $ref = (new ReferralRepository())->store([
                            'phone' => $user->phone,
                            'referee_phone' => $message
                        ]);

                        $user->session = 11;
                    } else
                        $user->session = 12;
                }

            } catch (NumberParseException $e) {
//                $user->session
                $user->session = 12;

                Log::info($e);

            }
        }

        $user->save();

        switch ($user->session) {
            case 11:

                $response = "Thank you for referring Sidooh. Your friend will receive a referral SMS. Once they register and purchase airtime (anything) within 48hrs you will start earning your referral points for every purchase they & their referral group make through Sidooh. \n\n";

                break;

            case 12:
                $user->session = 1;
                $user->save();

                $response = "Sorry, the number is not eligible for a referral. It’s already registered with a member. Try a different number to start earning from all their purchases once they enroll within 48hrs. \n\n";
                $response .= "Enter your friend’s mobile no: (format 2547xxxxxxxx) \n\n";

                break;

            default:

                $response = "Refer your friends to use Sidooh & start earning from all their purchases once they enroll within 48hrs. \n\n";
                $response .= "Enter your friend’s mobile no:
                            (format 2547xxxxxxxx) \n";

        }

        $response .= "\n0. Go back \t00. Go Home";

        return $response;
    }

    public function removeExpiredReferrals()
    {
        $refs = $this->expired()->delete();

        Log::info($refs);
    }
}