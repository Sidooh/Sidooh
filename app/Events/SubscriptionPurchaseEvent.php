<?php


namespace App\Events;


use App\Model\Transaction;
use App\Models\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionPurchaseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Subscription
     */
    public $subscription;

    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription, Transaction $transaction)
    {
        //
        $this->subscription = $subscription;
        $this->transaction = $transaction;
    }
}