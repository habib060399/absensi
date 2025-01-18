<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Helpers\Helper;

class AbsenController extends Controller
{
    function siswaGetOption(Request $request){
        $array = Helper::access();

        if(in_array($this->jurusan(), $array) && in_array($this->sekolah(), $array)) {
            $siswa = Siswa::where('id_sekolah', session('id_sekolah'))->where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->get();
            for ($i=0; $i < count($siswa); $i++) {
                echo "<option value=".$siswa[$i]['id']." selected> ".$siswa[$i]['nama_siswa']."</option>";
            }
        }elseif (in_array($this->sekolah(), $array)) {
            $siswa = Siswa::where('id_sekolah', session('id_sekolah'))->where('id_kelas', $request->id_kelas)->get();
            for ($i=0; $i < count($siswa); $i++) {
                echo "<option value=".$siswa[$i]['id']." selected> ".$siswa[$i]['nama_siswa']."</option>";
            }
        }elseif (in_array($this->kelas(), $array) && in_array($this->jurusan(), $array)) {
            $siswa = Siswa::where('id_sekolah', session('id_sekolah'))->where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->get();
            for ($i=0; $i < count($siswa); $i++) {
                echo "<option value=".$siswa[$i]['id']." selected> ".$siswa[$i]['nama_siswa']."</option>";
            }
        }else{
            $siswa = Siswa::where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->get();
            for ($i=0; $i < count($siswa); $i++) {
                echo "<option value=".$siswa[$i]['id']." selected> ".$siswa[$i]['nama_siswa']."</option>";
            }
        }

    }

    public function getAllAbsen(Request $request)
    {
        $array = Helper::access();
        $data_array = array();

        if((in_array($this->sekolah(), $array) || in_array($this->kelas(), $array)) && in_array($this->jurusan(), $array)) {
            $siswa = Siswa::join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->select('absensi.*', 'siswa.nama_siswa')->get();
            foreach ($siswa as $s) {
                $data_array[] = array(
                    'id' => $s->id_siswa,
                    'title' => $s->nama_siswa ." - ". $s->status,
                    'start' => $s->tanggal ." ".  $s->waktu
                );
            }
            return json_encode($data_array);
        }elseif (in_array($this->sekolah(), $array) || in_array($this->kelas(), $array)) {
            $siswa = Siswa::join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('id_kelas', $request->id_kelas)->select('absensi.*', 'siswa.nama_siswa')->get();
            foreach ($siswa as $s) {
                $data_array[] = array(
                    'id' => $s->id_siswa,
                    'title' => $s->nama_siswa ." - ". $s->status,
                    'start' => $s->tanggal ." ".  $s->waktu
                );
            }
            return json_encode($siswa);
        }elseif (in_array($this->kelas(), $array) && in_array($this->jurusan(), $array)) {
            $siswa = Siswa::join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('id_jurusan', Helper::decryptUrl($request->id_jurusan))->where('id_kelas', $request->id_kelas)->select('absensi.*', 'siswa.nama_siswa')->get();
            foreach ($siswa as $s) {
                $data_array[] = array(
                    'id' => $s->id_siswa,
                    'title' => $s->nama_siswa ." - ". $s->status,
                    'start' => $s->tanggal ." ".  $s->waktu
                );
            }
            return json_encode($data_array);
        }
    }
}
