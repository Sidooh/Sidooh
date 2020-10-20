<?php


namespace App\Models\Repositories;

use App\Models\Events\ReferralJoinedEvent;
use App\Models\Helpers\Sidooh\Report;
use App\Models\Model\Account;
use App\Models\Models\Voucher;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use MrAtiebatie\Repository;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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

    public function store(Request $request): Voucher
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
