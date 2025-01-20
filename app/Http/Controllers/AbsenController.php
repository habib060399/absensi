<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CurlController;
use App\Models\Absensi;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class AbsenController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date|before:tomorrow'
        ]);

        if($validator->fails()){
//            dd(implode($validator->getMessageBag()->get('tanggal')));
            return redirect()->route('absen')->with('error', implode($validator->getMessageBag()->get('tanggal')));
        }

        $curl = new CurlController();
        $time_now = date("h:i:s");

        $id_siswa = $request->input('nama');
        $status = $request->input('status_kehadiran');
        $tanggal = $request->input('tanggal');
        $data = array();

        for ($i=0; $i < count($id_siswa); $i++) {
            $get_absen = Absensi::where('id_siswa', $id_siswa[$i])->where('tanggal', $tanggal)->first();
            if(!$get_absen) {
                $data[$i] = $id_siswa[$i];
            }

        }

        if($data != null){
            $sekolah = Sekolah::where('id', (session('id_sekolah')) ? session('id_sekolah') : session('id'))->first();
            $teks = $sekolah->broadcast()->first()->template_bc;
            $json = serialize($teks);
            $unserialize = unserialize($json);
            $decode = json_decode($unserialize);

            switch ($status) {
                case 'hadir':
                    for($a=0; $a < count($data); $a++) {
                        $get_siswa = Siswa::where('id', $data[$a])->first();
                        $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, $decode->data[0]->message);
                        Absensi::create([
                            'id_siswa' => $data[$a],
                            'tanggal' => $tanggal,
                            'waktu' => $time_now,
                            'status' => $status
                        ]);
                    }
                    return redirect()->route('absen')->with('success', 'Data berhasil ditambahkan');
                    break;
                case 'absen':
                    for($a=0; $a < count($data); $a++) {
                        $get_siswa = Siswa::where('id', $data[$a])->first();
                        $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, $decode->data[2]->message);
                        Absensi::create([
                            'id_siswa' => $data[$a],
                            'tanggal' => $tanggal,
                            'waktu' => $time_now,
                            'status' => $status
                        ]);
                    }
                    return redirect()->route('absen')->with('success', 'Data berhasil ditambahkan');
                    break;
                case 'izin':
                    for($a=0; $a < count($data); $a++) {
                        $get_siswa = Siswa::where('id', $data[$a])->first();
                        $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, $decode->data[3]->message);
                        Absensi::create([
                            'id_siswa' => $data[$a],
                            'tanggal' => $tanggal,
                            'waktu' => $time_now,
                            'status' => $status
                        ]);
                    }
                    return redirect()->route('absen')->with('success', 'Data berhasil ditambahkan');
                    break;
                case 'sakit':
                    for($a=0; $a < count($data); $a++) {
                        $get_siswa = Siswa::where('id', $data[$a])->first();
                        $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, $decode->data[1]->message);
                        Absensi::create([
                            'id_siswa' => $data[$a],
                            'tanggal' => $tanggal,
                            'waktu' => $time_now,
                            'status' => $status
                        ]);
                    }
                    return redirect()->route('absen')->with('success', 'Data berhasil ditambahkan');
                    break;
                default:
                    return redirect()->route('absen')->with('error', 'status tidak boleh kosong');
                    break;
            }

        }

        return redirect()->route('absen')->with('error', 'Absen sudah terisi!');
    }
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
