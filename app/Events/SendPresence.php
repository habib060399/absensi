<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Sekolah;
use App\Models\Mesin;

class SendPresence implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name_student;
    public $date;
    public $time;
    public $id_kelas;
    public $id_mesin;

    public function __construct($name_student, $date, $time, $id_kelas, $id_sekolah)
    {
        $sekolah = Sekolah::where('id', $id_sekolah)->first();
        $mesin = Mesin::where('id', $sekolah->id_mesin)->first();

        $this->name_student = $name_student;
        $this->date = $date;
        $this->time = $time;
        $this->id_kelas = $id_kelas;
        $this->id_mesin = $mesin->id_mesin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('live-presence'),
        ];
    }
}
