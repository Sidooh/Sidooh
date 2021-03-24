<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Http\Controllers\Controller;
use App\Repositories\UssdRepository;

class UssdController extends Controller
{
    //

    protected $ussd;

    /**
     * UssdController constructor.
     *
     * @param UssdRepository $ussd
     */
    public function __construct(UssdRepository $ussd)
    {
        $this->ussd = $ussd;
    }


    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        //
//        $this->ussd->processAirtimeUSSD();
//        return new UssdRepository($this->ussd->process());
//        'END Thank you for reaching out.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function ussd()
    {
        //
        $this->ussd->processRefactored();
//        return new UssdRepository($this->ussd->process());
//        'END Thank you for reaching out.';
    }

    /**
     * Test sending of sms
     *
     * @return string
     */
    public function sms()
    {

        return (new AfricasTalkingApi())->sms(request()->phone, request()->message);

    }

    /**
     * Test purchase of airtime
     *
     * @return string
     */
    public function airtime()
    {

        return (new AfricasTalkingApi())->airtime(request()->phone, 5);

    }

    /**
     * Test status of transaction
     *
     * @return string
     */
    public function transaction()
    {

        return json_encode((new AfricasTalkingApi())->transactionStatus('ATQid_da73e457651f560e415b36f17a61817d'));

    }

    /**
     * Test stk push
     *
     * @return string
     */
    public function stk()
    {

        return mpesa_request(request()->phone, 5, '000-TEST', "STK Test");

    }

    /**
     * Test stk push
     *
     * @return string
     */
    public function b2c()
    {

        $b2c = mpesa_send(request()->phone, 5, "B2C Test");

        return $b2c;
    }

}
