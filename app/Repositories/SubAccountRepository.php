<?php


namespace App\Repositories;

use App\Model\Account;
use App\Models\SubAccount;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

class SubAccountRepository extends Model
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
        $this->model = app(SubAccount::class);
    }

    public function store(Account $acc, string $type): SubAccount
    {
        $arr = [
            'type' => $type,
            'account_id' => $acc->id
        ];

        $acc = $this->firstOrCreate($arr);

        return $acc;
    }

}
