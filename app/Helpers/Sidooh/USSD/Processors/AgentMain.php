<?php

namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;

class AgentMain extends Product
{
    /**
     * @param UssdUser $user
     * @param Screen $previousScreen
     * @param Screen $screen
     * @return Screen
     */
    public function process(UssdUser $user, Screen $previousScreen, Screen $screen)
    {
        return parent::process($user, $previousScreen, $screen);
    }

    public function getSubProduct($user, $sessionId, string $option)
    {
        error_log("----------------");
        error_log($option);
        error_log("----------------");

        switch ($option) {
            case "1":
                error_log("Getting sub product 1");
                return new Pre_Agent($user, $sessionId);
            case "2":
                error_log("Getting sub product 2");
                return new Agent($user, $sessionId);
            default:
                return $this;
        }
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Agent Main: finalize");
    }
}
