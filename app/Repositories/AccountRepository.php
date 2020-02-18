<?php


namespace App\Repositories;

use App\Model\Account;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

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

}