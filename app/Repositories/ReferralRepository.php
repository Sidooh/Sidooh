<?php


namespace App\Repositories;

use App\Model\Referral;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        if ($request->has('account_id'))
            $acc = (int)$request->get('account_id');
        else {
            $acc = AccountRepository::firstOrCreate(['phone' => $request['phone']])->id;
        }

        $arr = [
            'referee_phone' => $request['referee_phone'],
            'account_id' => $acc
        ];

        Log::info($arr);

        return $this->create($arr);

    }
}