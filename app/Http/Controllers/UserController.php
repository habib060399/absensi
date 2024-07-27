<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Settings;
use App\Helpers\Helper;
use Maatwebsite\Excel\facades\Excel;
use App\Exports\TemplateDaftarSiswa;
use App\Exports\RekapAbsen;
use App\Imports\SiswaImport;
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

    public function editKelas($id)
    {
        $get_jurusan = jurusan::where('id_sekolah', Helper::getSession())->get();
        // $get_kelas = Kelas::where('id', Helper::decryptUrl($id))->first();
        dd(Helper::decryptUrl($id), $get_jurusan);
    }

    public function registerSiswa(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'email' => 'required',
            'jurusan_sekolah' => 'required',
            'kelas_sekolah' => 'required',
            'no_hp' => 'required',
            'no_hp_ortu' => 'required',
            'rfid' => 'required|unique:siswa,rfid',
        ]);

        $siswa = Siswa::create([
            'id_sekolah' => $request->session()->get('id'),
            'id_jurusan' => $request->input('jurusan_sekolah'),
            'id_kelas' => $request->input('kelas_sekolah'),
            'nama_siswa' => $request->input('nama_siswa'),
            'rfid' => $request->input('rfid'),
            'email' => $request->input('email'),
            'no_hp' =>  $request->input('no_hp'),
            'no_hp_ortu' => $request->input('no_hp_ortu')
        ]);
        
        return redirect()->route('siswa_add')->with('status', 'asdfasdf');
    }

    public function getKelas(Request $request)
    {
        $kelas = Kelas::where('id_jurusan', $request->id_jurusan)->get();
        $get_kelas = $request->id_kelas;

        if($kelas){
            foreach ($kelas as $k) {
                if($k->id == $get_kelas){
                    echo "<option value='$k->id' selected > $k->kelas</option>";
                }

                echo "<option value='$k->id'> $k->kelas</option>";
                
            }
        }else{
            echo '<option selected disabled>Pilih Kelas</option>';
        }      
    }

    public function hapus($model, $id)
    {
        $get_model = "App\Models\\".$model;
        $get_model::where('id', Helper::decryptUrl($id))->delete();

        return redirect()->route('siswa')->with('hapus', 'asdfasd');
    }

    public function hapusKelas($id)
    {
        $siswa = Siswa::where('id_kelas', Helper::decryptUrl($id))->get();
        if(empty($siswa[0])){
            Kelas::where('id', Helper::decryptUrl($id))->delete();
            return redirect()->route('kelas')->with('hapus', 'asdfas');
        }else{
            return redirect()->route('kelas')->with('error', 'Data Siswa Masih Ada!');
        }
        
    }

    public function hapusJurusan($id)
    {
        $kelas = Kelas::where('id_jurusan', Helper::decryptUrl($id))->get();
        if(empty($kelas[0])){
            Jurusan::where('id', Helper::decryptUrl($id))->delete();
            return redirect()->route('jurusan')->with('hapus', 'asfdas');
        }else{
            return redirect()->route('jurusan')->with('error', 'Data Jurusan Masih Ada!');
        }
    }

    public function editJurusan(Request $request)
    {
        Jurusan::where('id', $request->input('id_edit_jurusan'))->update(['nama_jurusan' => $request->input('edit_jurusan')]);
        return redirect()->route('jurusan')->with('status', 'asadf');
    }

    public function editPesan(Request $request)
    {
        $get_id = $request->input('id_sekolah');
        Settings::where('id_sekolah', Helper::decryptUrl($get_id))->update(['bc' => $request->input('broadcast')]);
        return redirect()->route('bc')->with('status', 'asdfasd');
    }

    public function getAbsen(Request $request)
    {
        $siswa = Siswa::join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('id_jurusan', $request->id_jurusan)->where('id_kelas', $request->id_kelas)->select('absensi.*', 'siswa.nama_siswa')->get();
        $data_array = array();
        foreach ($siswa as $s) {
            $data_array[] = array(
                'id' => $s->id_siswa,
                'title' => $s->nama_siswa ." - ". $s->status,
                'start' => $s->tanggal ." ".  $s->waktu
            );
        }

        return json_encode($data_array);
    }

    public function insertAbsenManual(Request $request){
        $time_now = date("h:i:s");
        $date_now = date("Y-m-d");  
        
        $id_siswa = $request->input('id_siswa');
        $status = $request->input('status_kehadiran');
        
        Absensi::create([
            'id_siswa' => $id_siswa,
            'tanggal' => $date_now,
            'waktu' => $time_now,
            'status' => $status
        ]);
        return redirect()->route('absen')->with('status', 'Data berhasil ditambahkan');
    }

    public function delAbsen($id, $tanggal){
        // dd($id, $tanggal);
        Absensi::where('id_siswa', $id)->where('tanggal', $tanggal)->delete();

        return redirect()->route('absen')->with('hapus', 'asdf');
    }

    public function editAbsen(Request $request){
        $absen = Absensi::where('id_siswa', $request->id_siswa)->where('tanggal', $request->tanggal)->first();
        $status = ["hadir", "izin", "sakit"];
        $string ="";
        // dd($absenn);

        foreach($status as $s) {
         if($s == $absen->status){
            echo "<option selected disabled>$s</option>";
         }
         echo "<option value='$s'>$s</option>";
        }
    }

    public function insertEditAbsen(Request $request){

        Absensi::where('id_siswa', $request->id)->where('tanggal', $request->tanggal)->update(['status' => $request->status]);

        session(['status' => 'data berhasil ditambahkan']);
        return response()->json([
            'url' => route('absen'),
            'status' => 200,
            'message' => 'data berhasil ditambahkan'
        ]);
    }

    public function exportTemplateSiswa() {
        return Excel::download(new TemplateDaftarSiswa, "template-daftar-siswa.xlsx");
    }

    public function importSiswa(Request $request) {
        $request->validate([
            'file' => 'required|max:2048'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return back()->with('status', 'asfgfsdgd');
    }

    public function rekapAbsen(Request $request) {
        $data = [
            $request->input('get_jurusan'),
            $request->input('get_kelas'),
            $request->input('tgl_mulai'),
            $request->input('tgl_selesai'),
            session('id')
        ];

        // $absen = Siswa::join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('id_jurusan', $request->input('get_jurusan'))->where('id_kelas', $request->input('get_kelas'))->select('absensi.*','nama_siswa')->get();
        // $date = date('F', strtotime($request->input('tgl_mulai')));
        $rekap = new RekapAbsen( $request->input('get_jurusan'), $request->input('get_kelas'), $request->input('tgl_mulai'), $request->input('tgl_selesai'));
        return Excel::download($rekap, "Absen-siswa.xlsx");
        // dd($date, date('F'), $request->input('tgl_mulai'), (int)$request->input('tgl_mulai'));
    }
}