<?php


namespace App\Repositories;


use App\Model\Product;
use MrAtiebatie\Repository;

class ProductRepository
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
        $this->model = app(Product::class);
    }

    public function store(array $array): Product
    {
        $prod = $this->firstOrCreate($array);

        return $prod;
    }
}