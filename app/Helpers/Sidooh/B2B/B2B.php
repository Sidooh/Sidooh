<?php


namespace App\Helpers\Sidooh\B2B;


use DrH\Mpesa\Database\Entities\MpesaBulkPaymentRequest;
use DrH\Mpesa\Exceptions\MpesaException;
use DrH\Mpesa\Library\ApiCore;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Eloquent\Model;
use function config;

/**
 * Class BulkSender
 *
 * @package Samerior\MobileMoney\Mpesa\Library
 */
class B2B extends ApiCore
{
    /**
     * @var string
     */
    private $paybill;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var string
     */
    private $remarks = 'B2B Transfer';
    /**
     * @var int
     */
    private $trials = 3;


    /**
     * Set paybill to receive the funds
     *
     * @param string $paybill
     * @return $this
     */
    public function to($paybill): self
    {
        $this->paybill = $paybill;
        return $this;
    }

    public function withRemarks($remarks): self
    {
        $this->remarks = $remarks;
        return $this;
    }

    /**
     * The amount to transact
     *
     * @param  $amount
     * @return $this
     */
    public function amount($amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string|null $paybill
     * @param int|null    $amount
     * @param string|null $remarks
     * @return MpesaBulkPaymentRequest|Model
     * @throws GuzzleException
     * @throws MpesaException
     */
    public function send(string $paybill = null, $amount = null, $remarks = null)
    {
        $body = [
            'Initiator' => config('samerior.mpesa.b2b.initiator'),
            'SecurityCredential' => config('samerior.mpesa.b2c.security_credential'),
            'CommandID' => 'BusinessPayBill', //BusinessPayBill, MerchantToMerchantTransfer, MerchantTransferFromMerchantToWorking, MerchantServicesMMFAccountTransfer, AgencyFloatAdvance
            'SenderIdentifierType' => 4,
            'RecieverIdentifierType' => 4,
            'Amount' => $amount ?: $this->amount,
            'PartyA' => config('samerior.mpesa.b2b.short_code'),
            'PartyB' => $paybill ?: $this->paybill,
            'AccountReference' => "12",
            'Remarks' => $remarks ?: $this->remarks,
            'QueueTimeOutURL' => config('samerior.mpesa.b2b.timeout_url') . 'b2b',
            'ResultURL' => config('samerior.mpesa.b2b.result_url') . 'b2b',
        ];

        error_log(implode(' | ', $body));

        try {
            $response = $this->sendRequest($body, 'b2b');
            return $this->mpesaRepository->saveB2cRequest($response, $body);
        } catch (ServerException $exception) { //sometimes this endpoint behaves weird even for a nice request lets retry 1 atleast
            if ($this->trials > 0) {
                $this->trials--;
                return $this->send($paybill, $amount, $remarks);
            }
            throw new MpesaException('Server Error');
        }
    }


}
