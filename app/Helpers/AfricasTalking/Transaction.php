<?php


namespace App\Helpers\AfricasTalking;


class Transaction extends \AfricasTalking\SDK\Service
{
    public function check($parameters, $options = [])
    {
        if (empty($parameters['transactionId'])) {
            return $this->error("transactionId must be specified");
        }

        $response = $this->client->get('query/transaction/find?username=' . $this->username . '&transactionId=' . $parameters['transactionId']);

        return $this->success($response);
    }
}
