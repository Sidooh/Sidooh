<?php


namespace App\Helpers\Sidooh;


class Airtime
{
    /**
     * Phone number to purchase airtime for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Airtime amount.
     *
     * @var integer
     */
    protected $amount;

    /**
     * Purchase method.
     *
     * @var string
     */
    protected $method;

    /**
     * Make the initializations required to purchase airtime
     * @param $amount
     * @param $phone
     * @param string $method
     */
    public function __construct($amount, $phone, $method = 'MPESA')
    {
        $this->amount = $amount;
        $this->phone = $phone;
        $this->method = $method;
    }

    public function purchase()
    {

        mpesa_request($this->phone, $this->amount, '001-AIRT', 'Airtime Purchase');

        return true;

//        return (new AfricasTalkingApi())->airtime($this->phone, $this->amount);
    }


}