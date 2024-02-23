<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function cekAbsensi($rfid)
    {
        $absen = new Absensi();
        $user = new User();
        $time_now = date("h:i:s");
        $date_now = date("d-m-Y"); 
        $get_date="";
        $get_absen_user = $absen->getAbsen($rfid);
        $get_user = $user->getUser($rfid);
            
            if($get_absen_user != null){
                foreach($get_absen_user as $a){
                    $get_date = $a->tanggal;
                }
                if($date_now == $get_date){
                    return 2;
                }else{
                    $absen->setAbsen($rfid, $date_now, $time_now, $get_user->name);
                    return 1;
                }
                // }
            }else{
                $absen->setAbsen($rfid, $date_now, $time_now, $get_user->name);
                return 1;                
            }
            // return $status;

            // return 1;
    }

    public function registerJurusan(Request $request)
    {                
        Jurusan::create([
            'id_sekolah' => Helper::getSession(),
            'nama_jurusan' => $request->input('jurusan')
        ]);

        return redirect()->route('jurusan')->with('status', 'sadf');
    }

    public function registerKelas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jurusan' => 'required',
            'kelas' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('kelas')->with('error', 'Data Tidak Boleh Kosong');
        }
        $validated = $validator->validated();

        Kelas::create([
            'id_sekolah' => Helper::getSession(),
            'id_jurusan' => $request->input('jurusan'),
            'kelas' => $request->input('kelas'),
        ]);

        return redirect()->route('kelas')->with('status', 'sadfasd');
    }
}