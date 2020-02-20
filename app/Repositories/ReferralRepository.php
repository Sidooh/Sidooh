<?php


namespace App\Repositories;

use App\Model\Referral;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
     * @var \Illuminate\Database\Eloquent\Model
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

    public function store(Request $request): Referral
    {
        if ($request->has('account_id'))
            $acc = (int)$request->get('account_id');
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

    public function validatePhone(string $phoneNumber)
    {
        $country = null;

        if (substr($phoneNumber, 0, 1) !== '+')
            $phoneNumber = '+' . $phoneNumber;

        try {
            $country = PhoneNumber::make($phoneNumber)->getCountry();
        } catch (NumberParseException $e) {
            Log::info($e);
        }

        return $country ? true : false;
    }

    public function findByPhone(string $phoneNumber): ?Referral
    {
        $valid = $this->validatePhone($phoneNumber);

        return !$valid ? abort(422, 'Phone seems to be invalid.') :

            $this->timeActive()
                ->whereRefereePhone($phoneNumber)
                ->first();
    }

    public function checkReferral(int $id): Referral
    {
        return $this->findorFail($id);
    }
}