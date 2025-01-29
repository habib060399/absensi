<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Helpers\Helper;

class ApiController extends Controller
{
    public function searchNamaSiswa(Request $request)
    {
        if($request->search == ""){
            return null;
        }

        $list = array();
        $key=0;
        $array = Helper::getAccess(Helper::decryptUrl($request->id_user));

        if((in_array($this->sekolah(), $array) || in_array($this->kelas(), $array)) && in_array($this->jurusan(), $array)) {
            $siswa = Siswa::where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->where('nama_siswa', 'LIKE', '%'.$request->search.'%')->get();
            foreach ($siswa as $s) {
                $list[$key]['id'] = $s->id;
                $list[$key]['text'] = $s->nama_siswa;
                $key +=1;
            }
            return json_encode($list);
        }elseif (in_array($this->sekolah(), $array) || in_array($this->kelas(), $array)) {
            $siswa = Siswa::where('id_kelas', $request->id_kelas)->where('nama_siswa', 'LIKE', '%'.$request->search.'%')->get();
            foreach ($siswa as $s) {
                $list[$key]['id'] = $s->id;
                $list[$key]['text'] = $s->nama_siswa;
                $key +=1;
            }
            return json_encode($list);
        }elseif (in_array($this->kelas(), $array) && in_array($this->jurusan(), $array)) {
            $siswa = Siswa::where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->where('nama_siswa', 'LIKE', '%'.$request->search.'%')->get();
            foreach ($siswa as $s) {
                $list[$key]['id'] = $s->id;
                $list[$key]['text'] = $s->nama_siswa;
                $key +=1;
            }
            return json_encode($list);
        }
        return 'hello';
    }
}
