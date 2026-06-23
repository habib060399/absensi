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
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Sekolah;

class SendPresence implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel(
            'Presence.'.$this->data["id_sekolah"] . '.' . $this->data["id_jurusan"] . '.' . $this->data["id_kelas"]
        );
    }

    public function broadcastWith()
    {
        // $jurusan = Jurusan::where("id", $this->data["id_jurusan"])->first();
        // $kelas = Kelas::where("id", $this->data["id_kelas"])->first();
        return [
            'name' => $this->data['nama_siswa'],
            'foto' => $this->data['foto']
            // 'jurusan' => $jurusan->nama_jurusan,
            // 'kelas' => $kelas->kelas
        ];
    }
}
