<?php

namespace App\Events;

use App\Models\AirtimeResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AirtimePurchaseFailedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var AirtimeResponse
     */
    public $airtime_response;

    /**
     * Create a new event instance.
     *
     * @param AirtimeResponse $response
     */
    public function __construct(AirtimeResponse $response)
    {
        //
        $this->airtime_response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
