<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class AbsenController extends Controller
{
    function siswaGetOption(Request $request){
        $siswa = Siswa::where('id_sekolah', (session('id_sekolah')) ? session('id_sekolah') : session('id'))->where('id_jurusan', $request->id_jurusan)->where('id_kelas', $request->id_kelas)->get();
        
        if($siswa){
            for ($i=0; $i < count($siswa); $i++) { 
                echo "<option value=".$siswa[$i]['id']." selected> ".$siswa[$i]['nama_siswa']."</option>";
            }
        }else{
            echo "Tidak ada Data";
        }
    }
}
