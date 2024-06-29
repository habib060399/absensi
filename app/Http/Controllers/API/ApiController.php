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
        $siswa = Siswa::where('id_sekolah', $request->id_sekolah)->where('id_jurusan', $request->id_jurusan)->where('nama_siswa', 'LIKE', '%'.$request->search.'%')->get();
        
        $no=0;
        foreach ($siswa as $s) {
            $no +=1;
            $count_siswa = $siswa->count();
            echo "<option class='selection_$no' id='nama_siswa' value='$s->nama_siswa' data-siswa='$count_siswa' onclick='namaSiswa($no)'>$s->nama_siswa</option>";
        }
        // return response()->json([
        //     'siswa' => $this->a(),
        //     ''
        // ]);
    }
}
