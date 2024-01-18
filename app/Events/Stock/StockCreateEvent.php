<?php

namespace App\Events\Stock;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockCreateEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $stockId;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($stockId, $data)
    {
        $this->stockId = $stockId;
        $this->data = $data;
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
