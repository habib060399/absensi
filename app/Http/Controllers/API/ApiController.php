<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class ApiController extends Controller
{
    public function searchNamaSiswa(Request $request)
    {
        if($request->search == ""){
            return null;
        }
        $siswa = Siswa::where('id_sekolah', $request->id_sekolah)->where('id_jurusan', $request->id_jurusan)->where('id_kelas', $request->id_kelas)->where('nama_siswa', 'LIKE', '%'.$request->search.'%')->get();
        $list = array();
        $key=0;
        foreach ($siswa as $s) {
            $list[$key]['id'] = $s->id;
            $list[$key]['text'] = $s->nama_siswa;
            $key +=1;            
        }
        return json_encode($list);
    }
}
