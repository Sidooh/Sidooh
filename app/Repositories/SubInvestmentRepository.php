<?php


namespace App\Repositories;

use App\Models\SubInvestment;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
 * App\Repositories\SubInvestmentRepository
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $collective_investment_id
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereCollectiveInvestmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereUpdatedAt($value)
 * @mixin IdeHelperSubInvestmentRepository
 */
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
