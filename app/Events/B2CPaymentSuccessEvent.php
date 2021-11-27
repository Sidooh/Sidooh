<?php

namespace App\Events;

use DrH\Mpesa\Database\Entities\MpesaBulkPaymentResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class B2cPaymentSuccessEvent
 * @package App\Events
 */
class B2CPaymentSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var MpesaBulkPaymentResponse
     */
    public $bulkPaymentResponse;
    /**
     * @var array
     */
    public $response;

    /**
     * B2cPaymentSuccessEvent constructor.
     * @param MpesaBulkPaymentResponse $mpesaBulkPaymentResponse
     * @param array $response
     */
    public function __construct(MpesaBulkPaymentResponse $mpesaBulkPaymentResponse, $response)
    {
        $this->bulkPaymentResponse = $mpesaBulkPaymentResponse;
        $this->response = $response;
    }
}
