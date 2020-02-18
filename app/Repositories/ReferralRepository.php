<?php


namespace App\Repositories;

use App\Model\Referral;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use MrAtiebatie\Repository;

class ReferralRepository extends Model
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
        $this->model = app(Referral::class);
    }

//    /**
//     * Find published products by SKU
//     * @param  {int} $sku
//     * @return {Product}
//     */
//    public function findBySku(int $sku): Product {
//        return $this->whereIsPublished(1)
//            ->whereSku($sku)
//            ->first();
//    }

    public function store(Request $request): Referral
    {

        $acc = AccountRepository::wherePhone($request['phone'])->first();

        $arr = [
            'referee' => $request['referee'],
            'account_id' => $acc->id
        ];

        $referral = $this->create();

    }
}