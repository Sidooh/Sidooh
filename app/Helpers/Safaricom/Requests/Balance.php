<?php


namespace App\Helpers\Safaricom\Requests;


use App\Helpers\Safaricom\MpesaClient;
use Illuminate\Support\Str;

class Balance extends MpesaClient
{
    /**
     * Safaricom Balance API endpoint.
     *
     * @var string
     */
    protected $queryEndPoint = 'mpesa/accountbalance/v1/query';

    /**
     * The initiator name for the short enquiring for balance.
     *
     * @var string
     */
    protected $initiatorName;

    /**
     * The encrypted security credential for the short code enquiring
     * for the balance.
     *
     * @var string
     */
    protected $securityCredential;

    /**
     * The URL where Safaricom Balance API will send result of the transaction.
     *
     * @var string
     */
    protected $resultURL;

    /**
     * The URL where Safaricom Balance API will send notification of the transaction
     * timing out while in the Safaricom servers queue.
     *
     * @var string
     */
    protected $queueTimeoutURL;

    /**
     * Balance constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initiatorName = config('mpesa.initiator.name');
        $this->securityCredential = $this->securityCredential(config('mpesa.intiator.credential'));

        $this->resultURL = $this->setUrl(config('mpesa.result_url.balance'));
        $this->queueTimeoutURL = $this->setUrl(config('mpesa.queue_timeout_url.balance'));
    }

    /**
     * Set initiator other than the one in the mpesa config file.
     *
     * @param string $initiatorName
     * @param string $securityCredential
     */
    public function setInitiator($initiatorName, $securityCredential)
    {
        $this->initiatorName = $initiatorName;
        $this->securityCredential = $this->securityCredential($securityCredential);
    }

    /**
     * Set the url that will handle the timeout response from the
     * MPESA Balance API.
     *
     * @param string $url
     */
    public function setQueueTimeoutURL($url)
    {
        $this->queueTimeoutURL = $url;
    }

    /**
     * Set the url that will handle the result of the transaction
     * from the MPESA Balance API.
     *
     * @param string $url
     */
    public function setResultURL($url)
    {
        $this->resultURL = $url;
    }

    /**
     * Send the balance query to the Safaricom Account Balance API.
     *
     * @param string $remarks
     * @param null|string $shortCode
     * @return mixed
     */
    public function query($remarks, $shortCode = null)
    {
        $parameters = [
            'Initiator' => $this->initiatorName,
            'SecurityCredential' => $this->securityCredential,
            'CommandID' => 'AccountBalance',
            'PartyA' => is_null($shortCode) ? config('mpesa.initiator.short_code') : $shortCode,
            'IdentifierType' => '4',
            'Remarks' => Str::limit($remarks, 100, ''),
            'QueueTimeOutURL' => $this->queueTimeoutURL,
            'ResultURL' => $this->resultURL,
        ];

        return $this->call($this->queryEndPoint, ['json' => $parameters]);
    }
}