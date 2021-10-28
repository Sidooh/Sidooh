<?php

namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;

class Pay extends Product
{
//    TODO: Is this function necessary?
    public function getSubProduct($user, $sessionId, string $option)
    {
        error_log("----------------");
        error_log($option);
        error_log("----------------");

        switch ($option) {
            case "1":
                error_log("Getting sub product 1");
                return new Subscription($user, $sessionId);
            case "2":
                error_log("Getting sub product 2");
                return new Voucher($user, $sessionId);
            case "3":
                error_log("Getting sub product 3");
                return new Merchant($user, $sessionId);
//                TODO: Check why this is not needed...
//            case "4":
//                error_log("Getting sub product 4");
//                return new Utility($user, $sessionId);
            default:
                return $this;
        }
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Pay: finalize");
    }
}
