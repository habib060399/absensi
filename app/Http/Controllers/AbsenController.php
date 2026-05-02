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
            'tanggal' => 'required|date|before:tomorrow',
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

        if(empty($id_siswa)){
            return redirect()->route('absen')->with('error', 'Siswa Wajib Diisi!');
        }
        $existing = Absensi::whereIn('id_siswa', $id_siswa)->where('tanggal', $tanggal)->pluck('id_siswa')->toArray();
        $data = array_diff($id_siswa, $existing);

        if (empty($data)) {
        return redirect()->route('absen')->with('error', 'Absen sudah terisi!');
        }

        $siswas = Siswa::whereIn('id', $data)->get()->keyBy('id');

        $sekolah = Sekolah::find(session('id_sekolah') ?? session('id'));
        $decode = json_decode($sekolah->broadcast()->first()->template_bc);

        $messageIndex = ['hadir' => 0, 'sakit' => 1, 'absen' => 2, 'izin' => 3];

        if (!isset($messageIndex[$status])) {
        return redirect()->route('absen')->with('error', 'status tidak valid');
        }

        $curl = new CurlController();

        foreach($data as $id){
            $siswa = $siswas[$id];

            $curl->sendWaAbsenManual(
                $siswa->no_hp_ortu,
                $siswa->nama_siswa,
                $siswa->id_sekolah,
                $decode->data[$messageIndex[$status]]->message,
                $siswa->id_kelas
            );

            Absensi::create([
            'id_siswa' => $id,
            'tanggal' => $tanggal,
            'waktu' => $time_now,
            'status' => $status
             ]);
        }

        return redirect()->route('absen')->with('success', 'Data berhasil ditambahkan');
        // return redirect()->route('absen')->with('error', 'Absen sudah terisi!');
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
