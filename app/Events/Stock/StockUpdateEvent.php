<?php

namespace App\Events\Stock;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdateEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $stockId;
    public $quantity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($stockId, $quantity)
    {
        $this->stockId = $stockId;
        $this->quantity = $quantity;
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
