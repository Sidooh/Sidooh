<?php

namespace App\Http\Controllers\Api\V1;

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
        $this->ussd->process();
//        return new UssdRepository($this->ussd->process());
//        'END Thank you for reaching out.';
    }
}
