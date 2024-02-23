<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class SendPresence implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $id_mesin;
    public $rfid_tag;

    public function __construct($rfid_tag, $id_mesin)
    {
      $this->id_mesin = $id_mesin;
      $this->rfid_tag = $rfid_tag;
    }

    public function broadcastWith()
    {   
        $getCookie = Cookie::get('id_mesin');
        if(strval($getCookie) == $this->id_mesin){
            return ['welcome' => $this->rfid_tag];
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('Presence'),
        ];
    }
}
