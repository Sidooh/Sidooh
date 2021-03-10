<?php

namespace App\Helpers\Sidooh\USSD\Entities;


abstract class MpesaReferences extends BasicEnum
{
    const AIRTIME = '1-AIRTIME';
    const PAY_SUBSCRIPTION = '2-SUBSCRIPTION';
    const PAY_VOUCHER = '3.2-VOUCHER';
    const PRE_AGENT_REGISTER_ASPIRING = '6.1-PRE-AGENT-ASPIRE';
    const PRE_AGENT_REGISTER_THRIVING = '6.2-PRE-AGENT';
    const AGENT_REGISTER_ASPIRING = '6.3-AGENT-ASPIRE';
    const AGENT_REGISTER_THRIVING = '6.4-AGENT';
}

