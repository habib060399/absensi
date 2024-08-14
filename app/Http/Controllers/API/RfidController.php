<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\CurlController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Mesin;
use App\Models\Siswa;
use App\Models\Settings;
use App\Events\SendPresence;
use App\Events\ScanRFID;

class RfidController extends Controller
{
    protected $modelAbsen;
    protected $modelUser;
    protected $controllerUser;
    protected $curl;

    public function __construct()
    {
        $this->modelAbsen = new Absensi();
        $this->modelUser = new User();
        $this->controllerUser = new UserController();
        $this->curl = new CurlController();             
    }
    
    public function index()
    {        
        return response()->json([
            'test' => 100,
            'status' => 200,
            'message' => $this->modelAbsen->getAll()
        ]);
    }

    public function login(Request $request)
    {        
        $get_perangkat = $this->perangkat->where('id_mesin', $request->id_mesin)->leftJoin('personal_access_tokens', 'perangkat.id_mesin', '=', 'personal_access_tokens.name')->select('perangkat.*', 'personal_access_tokens.token')->first();
        if($get_perangkat){
            if($get_perangkat->token == null){
                // $token = $get_perangkat->createToken($id_perangkat, ['token:check'])->plainTextToken;             
                $token = "fasdkfjalskdjflkasjdl";
                return response()->json([
                'id_mesin' => $get_perangkat->id_mesin,
                'message' => 'Data berhasil ditemukan',
                'token' => $token,
                'status' => 200
            ]);
        }
        }else{
            return response()->json([
                'id_mesin' => $request->id_mesin,
                'message' => 'Data tidak ditemukan',
                'status' => 404
            ]);
        }
    }
    
    public function store(Request $request)
    {   
        $time_now = date("h:i:s");
        $date_now = date("Y-m-d");     
        $get_siswa = Siswa::where('rfid', $request->rfid_tag)->first();
        if($get_siswa){
            $get_absen = Absensi::where('id_siswa', $get_siswa->id)->where('tanggal', $date_now)->first();
            if($get_absen){
                return response()->json([
                    'message' => 'Anda Sudah Melakukan Absen',
                    'status' => 200
                ]);
            }else{                
                $responseWa = $this->curl->curlWa($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah);
                if($responseWa) {
                    
                    Absensi::create([
                        'id_siswa' => $get_siswa->id,
                        'tanggal' => $date_now,
                        'waktu' => $time_now,
                        'status' => 'hadir'
                    ]);

                    broadcast(new SendPresence($get_siswa->nama_siswa, $date_now, $time_now, $get_siswa->id_kelas, $get_siswa->id_sekolah));

                    return response()->json([
                        'message' => "Pesan berhasil dikirim",
                        'message2' => "Absensi Berhasil",                   
                        'status' => 200
                    ]); 
                } else {
                    return response()->json([
                        'message' => "Gagal Mengirim Pesan",                    
                        'status' => 200
                    ]);
                }
      
            }
        }else{
            return response()->json([
                'message' => "RFID belum terdaftar",
                'status' => 400
            ]);
        }
    }    

    public function scan(Request $request)
    {
        $get_id_perangkat = Mesin::where('id_mesin', $request->id_mesin)->first();

        if($get_id_perangkat){
            broadcast(new ScanRFID($request->rfid_tag, $request->id_mesin));
            // Cookie::queue(Cookie::make('id_mesin', $request->id_mesin, 30));
            return response()->json([
                'id_mesin' => $request->id_mesin,
                'rfid_tag' => $request->rfid_tag,
                'status' => 200
            ]);
        }
    }
}