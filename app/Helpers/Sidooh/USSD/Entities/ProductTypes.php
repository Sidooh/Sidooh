<?php

namespace App\Helpers\Sidooh\USSD\Entities;


abstract class ProductTypes extends BasicEnum
{
    const DEFAULT = 0;
    const AIRTIME = 2;
    const PAY = 3;
    const SAVE = 4;
    const REFER = 5;
    const PAY_SUBSCRIPTION = 3.1;
}

