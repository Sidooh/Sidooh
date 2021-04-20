<?php

namespace App\Http\Controllers;

use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Http\Requests\WebAirtimePurchaseRequest;

class WebController extends Controller
{

    /**
     * Perform airtime purchase from website
     *
     * @return Response
     */
    public function airtimePurchase(WebAirtimePurchaseRequest $request)
    {
        //
        $nomineeNumber = $request->nominee_number;
        $amount = $request->amount;
        $target = $request->recipient;
        $mpesa = $request->mpesa_number;
        $method = PaymentMethods::MPESA;

//        TODO: Do we need to store all numbers bought for in our system? What if it is not a safaricom number?
        $transaction = (new \App\Helpers\Sidooh\Airtime($amount, $nomineeNumber, $method, 'WEB'))->purchase($target, $mpesa);

        session()->flash('success', 'Mpesa STK push sent. Please input pin when requested.');
        session(['stk' => true]);

        return back();
    }
}
