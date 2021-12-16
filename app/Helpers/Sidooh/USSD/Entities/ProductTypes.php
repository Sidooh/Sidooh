<?php

namespace App\Helpers\Sidooh\USSD\Entities;


abstract class ProductTypes extends BasicEnum
{
    const DEFAULT = 0;
    const AIRTIME = 2;
    const PAY = 3;
    const PAY_SUBSCRIPTION = 3.1;
    const PAY_VOUCHER = 3.2;
    const PAY_MERCHANT = 3.3;
    const SAVE = 4;
    const REFER = 5;
    const AGENT = 6;
    const PRE_AGENT_REGISTER = 6.1;
    const AGENT_REGISTER = 6.2;
    const ACCOUNT = 7;
    const PAY_UTILITY = 3.4;
}

