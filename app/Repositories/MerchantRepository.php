<?php


namespace App\Repositories;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
 * App\Repositories\MerchantRepository
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $contact_name
 * @property string $contact_number
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereUpdatedAt($value)
 * @mixin IdeHelperMerchantRepository
 */
class MerchantRepository extends Model
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
        $this->model = app(Merchant::class);
    }

    public function findByCode($code)
    {
        return $this->whereCode($code)
                ->first();
    }

}
