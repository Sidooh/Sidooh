<?php


namespace App\Repositories;

use App\Models\SubInvestment;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

class SubInvestmentRepository extends Model
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
        $this->model = app(SubInvestment::class);
    }

}
