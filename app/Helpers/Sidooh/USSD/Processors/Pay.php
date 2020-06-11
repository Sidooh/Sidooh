<?php

namespace App\Helpers\Sidooh\USSD\Processors;


class Pay extends Product
{
    public function getSubProduct($user, $sessionId, string $option)
    {
        switch ($option) {
            case 1 || "1":
                error_log("Getting sub product");
                return new Subscription($user, $sessionId);
        }
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Pay: finalize");
    }
}
