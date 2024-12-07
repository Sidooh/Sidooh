<?php


namespace App\Helpers\AfricasTalking;


class AfricasTalkingSubClass extends \AfricasTalking\SDK\AfricasTalking
{
    public function transaction()
    {
        $transaction = new Transaction($this->tokenClient, $this->username, $this->apiKey);
        return $transaction;
    }
}
