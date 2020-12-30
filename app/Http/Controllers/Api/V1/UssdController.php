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

        return (new AfricasTalkingApi())->sms(request()->phone, "This is a test sms!");

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
     * Test stk push
     *
     * @return string
     */
    public function stk()
    {

        return mpesa_request(request()->phone, 5, '000-TEST', "STK Test");

    }

}
