<?php

namespace App\Events\Ticket;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $ticket;


    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
