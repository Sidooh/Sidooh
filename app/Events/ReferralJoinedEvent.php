<?php

namespace App\Events;

use App\Models\Referral;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReferralJoinedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Referral
     */
    public $referral;

    /**
     * Create a new event instance.
     *
     * @param Referral $referral
     */
    public function __construct(Referral $referral)
    {
        //
        $this->referral = $referral;

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
