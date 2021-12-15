<?php


namespace App\Repositories;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

/**
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
