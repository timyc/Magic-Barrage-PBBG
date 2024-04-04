<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendCharacterInfo implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $character;
    public $chardata;
    public $clandata;
    public $itemdata;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $character, $chardata, $clandata, $itemdata)
    {
        $this->character = $character;
        $this->chardata = $chardata;
        $this->clandata = $clandata;
        $this->itemdata = $itemdata;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('character.' . $this->character);
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastWith()
    {
        return ['chardata'=>$this->chardata, 'clandata'=>$this->clandata, 'itemdata'=>$this->itemdata];
    }
}
