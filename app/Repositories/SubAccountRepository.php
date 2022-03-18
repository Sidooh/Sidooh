<?php


namespace App\Repositories;

use App\Models\Account;
use App\Models\SubAccount;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
 * App\Repositories\SubAccountRepository
 *
 * @property int $id
 * @property string $type
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereUpdatedAt($value)
 * @mixin IdeHelperSubAccountRepository
 */
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
