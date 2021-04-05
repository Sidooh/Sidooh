<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

class UserRepository
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
        $this->model = app(User::class);
    }

}
