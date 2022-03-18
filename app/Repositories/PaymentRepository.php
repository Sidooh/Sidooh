<?php


namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
 * App\Repositories\PaymentRepository
 *
 * @property int $id
 * @property int $payable_id
 * @property string $payable_type
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string $subtype
 * @property int $payment_id
 * @property string $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereUpdatedAt($value)
 * @mixin IdeHelperPaymentRepository
 */
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
