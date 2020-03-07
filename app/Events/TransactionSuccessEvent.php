<?php

namespace App\Events;

use App\Model\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * @var int
     */
    public $totalEarned;


    /**
     * Create a new event instance.
     *
     * @param Transaction $transaction
     * @param float $totalEarned
     */
    public function __construct(Transaction $transaction, float $totalEarned)
    {
        //

        $this->transaction = $transaction;
        $this->totalEarned = $totalEarned;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
