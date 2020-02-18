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
     * @var \Illuminate\Database\Eloquent\Model
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

        $arr = [
            'telco_id' => 1,
            'phone' => $phone,
        ];

        return $this->firstOrCreate($arr);

    }

}