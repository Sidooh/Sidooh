<?php


namespace App\Repositories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * @mixin IdeHelperVoucherRepository
 */
class VoucherRepository extends Model
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
        $this->model = app(Voucher::class);
    }

    public function storeOrCreate(array $request): Voucher
    {
        $phone = ltrim(PhoneNumber::make($request['phone'], 'KE')->formatE164(), '+');

        $acc = (new AccountRepository())->findByPhone($phone);

        if ($acc) {
            $arr = [
                'account_id' => $acc->id
            ];

            $voucher = $this->firstOrCreate($arr);
        } else {
            throw new NotFoundResourceException("Account Not found");
        }

        return $voucher;

    }

    public function create(array $acc): Voucher
    {
        error_log('-------------------');
        error_log($acc['phone']);
        error_log('-------------------');

        $phone = ltrim(PhoneNumber::make($acc['phone'], 'KE')->formatE164(), '+');

        $vou = $this->whereHas('account', function ($q) use ($phone) {
            return $q->where('phone', '=', $phone);
        })->first();

        return $vou;
    }

    public function findByPhone($phoneNumber, $throw = true)
    {
        $valid = (new ReferralRepository())->validatePhone($phoneNumber, $throw);

        return !$valid ? abort(422, 'Phone seems to be invalid.') :

            $this->whereHas('account', function ($q) use ($phoneNumber) {
                return $q->where('phone', '=', $phoneNumber);
            })->first();
    }

}
