<?php


namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

class PaymentRepository extends Model
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
        $this->model = app(Payment::class);
    }

}
