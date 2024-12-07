<?php


namespace App\Helpers\Sidooh\USSD\Entities;


class User
{
    private $id;

    private $stage;

    private $product;

    public function __construct($id, $product, $stage)
    {
        $this->id = $id;
        $this->product = $product;
        $this->stage = $stage;
    }
}
