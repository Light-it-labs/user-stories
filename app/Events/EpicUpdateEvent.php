<?php

namespace App\Events;

use App\Models\Epic;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EpicUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $epic;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct(Epic $epic)
     {
        $this->epic = $epic;
     }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new Channel('epic-channel');

        //Private Channel
         return new PrivateChannel('epic-channel.' . $this->epic->id);
    }
}
