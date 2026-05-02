<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Mesin;
use App\Models\Sekolah;
use App\Http\Controllers\API\CurlController;

class MqttSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $time_now = date("h:i:s");
        $date_now = date("Y-m-d");
        $curl = new CurlController();
        $mqtt = new MqttClient("192.168.100.54", 1883);
        $settings = (new ConnectionSettings)->setUsername("absensi")->setPassword("absensi");
        $mqtt->connect($settings, true);

        $mqtt->subscribe("absensi/rfid", function ($topic, $message) use ($mqtt, $date_now, $time_now, $curl){
            \Log::info("[$topic] $message");
            echo "[$topic] $message . \n";                       
            $data = json_decode($message, true);
            echo $data['id_mesin']."\n";
            

            $mesin = Mesin::where('id_mesin', $data['id_mesin'])->first();
            $expected = hash_hmac('sha256', $mesin->id_mesin, $mesin->mesin_secret);
            echo "$mesin->id"."\n";
            
            if($expected !== $data['signature']){
                return;
            }

            $get_siswa = Siswa::where('rfid', $data['rfid'])->first();
            if($get_siswa !== null){                
                $get_absen = Absensi::where('id_siswa', $get_siswa->id)->where('tanggal', $date_now)->first();
                if($get_absen){                    
                    $mqtt->publish("absensi/rfid/".$data['id_mesin'], json_encode([
                        "message" => "Anda Sudah Melakukan Absen",
                        "status" => 200
                    ]));
                }else{                    
                //     Absensi::create([
                //     'id_siswa' => $get_siswa->id,
                //     'tanggal' => $date_now,
                //     'waktu' => $time_now,
                //     'status' => 'hadir'
                // ]);
                
                $Wa = $curl->sendPresencenWa($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $mesin->id);

                $mqtt->publish("absensi/rfid/".$data['id_mesin'], json_encode([
                        "message" => "Absen berhasil",
                        "status" => 200
                    ]));
                }
            }else{                
                $mqtt->publish("absensi/rfid/".$data['id_mesin'], json_encode([
                        "message" => "Siswa Tidak Terdaftar !!!",
                        "status" => 200
                    ]));
            }
            

        });        

        $mqtt->loop(true);
    }
}
