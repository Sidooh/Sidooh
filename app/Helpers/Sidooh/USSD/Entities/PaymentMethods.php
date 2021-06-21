<?php

namespace App\Helpers\Sidooh\USSD\Entities;


abstract class PaymentMethods extends BasicEnum
{
    const __default = self::MPESA;

    const MPESA = "MPESA";
    const VOUCHER = "VOUCHER";
    const SIDOOH_POINTS = "Sidooh Points";
    const SIDOOH_BONUS = "Sidooh Bonus";
}

