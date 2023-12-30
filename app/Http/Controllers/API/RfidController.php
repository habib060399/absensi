<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\CurlController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;

class RfidController extends Controller
{
    
    public function index()
    {
        $modalAbsen = new Absensi();        

        return response()->json([
            'status' => 200,
            'message' => $modalAbsen->getAll()
        ]);
    }

    
    public function store(Request $request)
    {
        $modelUser = new User();
        $controllerUser = new UserController();
        $curl = new CurlController();

        $getUser = $modelUser->getUser($request->rfid_tag);

        if($getUser){
            $get = $controllerUser->cekAbsensi($request->rfid_tag);
            if($get == 1){
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
