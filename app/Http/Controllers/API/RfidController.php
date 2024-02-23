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
use App\Events\SendPresence;

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
        $getUser = $modelUser->getUser($request->rfid_tag);

        if($getUser){
            $get = $controllerUser->cekAbsensi($request->rfid_tag);
            if($get == 1){
                // broadcast(new SendPresence());
                return response()->json([
                    'status' => 'Name tag telah terdeteksi',
                    'message' => 200,                    
                    // 'respon_wa' => $curl->curlWa($getUser)
                   ]);
            }elseif($get == 2){
                return response()->json([
                    'status' => 'Anda Sudah Absen',
                    'message' => 200,                    
                   ]);
            }else{
                return response()->json([
                    'status' => 'Gagal Absen',
                    'message' => 500,                    
                   ]);
            }
            
        }else{
            $data = User::create([
             'rfid_tag' => $request->rfid_tag
            ]);
     
            return response()->json([
             'status' => 'Name tag berhasil ditambahkan ke database',
             'message' => 200,            
            ]);
        }        
    }    

    // public function checkIdDevice(Request $request)
    // {
    //     $getIdPerangkat = Perangkat::where('id_mesin', $request->id_mesin)->first();

    //     if($getIdPerangkat){
    //         return response()->json([
    //             'id_perangkat' => $getIdPerangkat->id_mesin,
    //             'status' => 200
    //         ]);
    //     } else{
    //         return response()->json([
    //             'id_perangkat' => null,
    //             'status' => 200
    //         ]);
    //     }
    // }

    public function scan(Request $request)
    {
        $get_id_perangkat = Mesin::where('id_mesin', $request->id_mesin)->first();

        if($get_id_perangkat){
            broadcast(new SendPresence($request->rfid_tag, $request->id_mesin));
            Cookie::queue(Cookie::make('id_mesin', $request->id_mesin, 30));
            return response()->json([
                'id_mesin' => $request->id_mesin,
                'rfid_tag' => $request->rfid_tag,
                'status' => 200
            ]);
        }
        // return response()->json([
        //     'id_mesin' => $request->id_mesin,
        //     'rfid_tag' => $request->rfid_tag,
        //     'status' => 200
        // ]);

    }
}