<?php

namespace App\Events\Stock;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockHistoryCreateEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $stock;
    public $quantity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($stock, $quantity)
    {
        $this->stock = $stock;
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
