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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateDaftarSiswa;
use App\Exports\RekapAbsen;
use App\Imports\SiswaImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\CurlController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

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
            'kelas' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('kelas')->with('error', 'Data Tidak Boleh Kosong');
        }
        $validated = $validator->validated();

        $kelas = new Kelas();
        $user = new User();
        $id = date('dmyHis');
        
        $user->id = intVal($id);
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $kelas->id_sekolah = Helper::getSession();
        $kelas->id_jurusan = $request->input('jurusan');
        $kelas->kelas = $request->input('kelas');
        $user->kelas()->save($kelas);
        $user->assignRole('kelas');
        $user->givePermissionTo('only class');

        return redirect()->route('kelas')->with('status', 'sadfasd');
    }

    public function editKelas($id, Request $request)
    {
        $id_kelas = Helper::decryptUrl($id);
        $get_kelas = Kelas::where('id_sekolah', Helper::getSession())->where('id', $id_kelas)->first();

        $get_kelas->id_jurusan = Helper::decryptUrl($request->input('jurusan'));
        $pass = $request->input('password');
        $get_kelas->kelas = $request->input('kelas');
        $get_kelas->user->username = $request->input('username');
        $get_kelas->save();

        if($pass != null){
            $get_kelas->user->password = Hash::make($pass);
            $get_kelas->user->save();
        }
        // $get_kelas->user->name = "Eko";
        // $get_kelas->user->save();
        // dd(Helper::decryptUrl($id), $get_kelas->user->name, $jurusan, $pass);
        return redirect()->route('kelas')->with('status', 'sadfasd');
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
            'foto' => 'image|max:2000'
        ]);

        $foto = $request->file('foto');
        $filename = Carbon::now()->format('YmdHis') . '.' . $foto->getClientOriginalExtension();

        
        $siswa = Siswa::create([
            'id_sekolah' => $request->session()->get('id'),
            'id_jurusan' => $request->input('jurusan_sekolah'),
            'id_kelas' => $request->input('kelas_sekolah'),
            'nama_siswa' => $request->input('nama_siswa'),
            'rfid' => $request->input('rfid'),
            'email' => $request->input('email'),
            'no_hp' =>  $request->input('no_hp'),
            'no_hp_ortu' => $request->input('no_hp_ortu'),
            'foto' => $filename
        ]);
        $foto->storePubliclyAs('foto', $filename);
        
        return redirect()->route('siswa_add')->with('status', 'asdfasdf');
    }

    public function editSiswa($id, Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'email' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'no_hp' => 'required',
            'no_hp_ortu' => 'required',
        ]);

        $foto = $request->file('foto');

        if($foto != null){
            $request->validate([
                'foto' => 'image|max:2000'
            ]);

            $get_siswa = Siswa::where('id', Helper::decryptUrl($id))->first();
            Storage::delete('foto/'.$get_siswa->foto);
            $filename = Carbon::now()->format('YmdHis') . '.' . $foto->getClientOriginalExtension();

            Siswa::where('id', Helper::decryptUrl($id))->update([
                'nama_siswa' => $request->input('nama_siswa'),
                'email' => $request->input('email'),
                'id_jurusan' => $request->input('jurusan'),
                'id_kelas' => $request->input('kelas'),
                'no_hp' => $request->input('no_hp'),
                'no_hp_ortu' => $request->input('no_hp_ortu'),
                'foto' => $filename
            ]);
            $foto->storePubliclyAs('foto', $filename);
    
            return redirect()->route('siswa')->with('status', 'asdfasdf');
        }else{
            Siswa::where('id', Helper::decryptUrl($id))->update([
                'nama_siswa' => $request->input('nama_siswa'),
                'email' => $request->input('email'),
                'id_jurusan' => $request->input('jurusan'),
                'id_kelas' => $request->input('kelas'),
                'no_hp' => $request->input('no_hp'),
                'no_hp_ortu' => $request->input('no_hp_ortu')
            ]);
    
            return redirect()->route('siswa')->with('status', 'asdfasdf');
        }

    }

    public function getKelas(Request $request)
    {
        $kelas = Kelas::where('id_jurusan', $request->id_jurusan)->get();
        $get_kelas = $request->id_kelas;
        $selected = '';

        if($kelas){
            echo "<option selected disabled>Pilih Kelas</option>";
            foreach ($kelas as $k) {
                if($k->id == $get_kelas){
                    $selected = 'selected';
                }
                echo "<option value='$k->id' $selected> $k->kelas</option>";
                $selected = '';
                
            }
        }else{
            echo '<option selected disabled>Pilih Kelas</option>';
        }      
    }

    public function hapusSiswa($id)
    {
        $get_siswa = Siswa::where('id', Helper::decryptUrl($id))->first();

        Storage::delete('foto/'.$get_siswa->foto);
        Siswa::where('id', Helper::decryptUrl($id))->delete();

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
        $settings = Settings::where('id_sekolah', Helper::decryptUrl($get_id))->first();
        if($settings){
            Settings::where('id_sekolah', Helper::decryptUrl($get_id))->update(['bc' => $request->input('broadcast')]);
        }else{
            // dd(Helper::decryptUrl($get_id));
            Settings::create([
                'id_sekolah' => Helper::decryptUrl($get_id),
                'bc' => $request->input('broadcast')
            ]);
            // dd('data baru dimasukkan');
        }
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
            for($a=0; $a < count($data); $a++) {
                Absensi::create([
                    'id_siswa' => $data[$a],
                    'tanggal' => $tanggal,
                    'waktu' => $time_now,
                    'status' => $status
                ]);
            }
            return redirect()->route('absen')->with('status', 'Data berhasil ditambahkan');
        }
        
        return redirect()->route('absen')->with('error', 'Absen sudah terisi!');
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
        $request->validate([
            'get_jurusan' => 'required',
            'get_kelas' => 'required',
            'tgl_mulai' => 'required|date|before_or_equal:tgl_selesai',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai'
        ]);

        $rekap = new RekapAbsen($request->input('get_jurusan'), $request->input('get_kelas'), $request->input('tgl_mulai'), $request->input('tgl_selesai'));
        return Excel::download($rekap, "Absen-siswa.xlsx");
    }

    public function getSiswa(Request $request){
        $siswa = Siswa::where('id_jurusan', $request->id_jurusan)->where('id_kelas', $request->id_kelas)->get();
        if($siswa){
            if($request->selected == "ortu"){
                foreach ($siswa as $s) {
                    
                    echo "<option value=".Helper::encryptUrl($s->no_hp_ortu)." selected> Ortu $s->nama_siswa</option>";                    
                }
            }elseif ($request->selected == "siswa") {
                foreach ($siswa as $s) {
                    echo "<option value=".Helper::encryptUrl($s->no_hp)." selected> $s->nama_siswa</option>";  
                }            
            }else {
                foreach ($siswa as $s) {
                    echo "<option value=".Helper::encryptUrl($s->no_hp)."> $s->nama_siswa</option>";  
                }            
            }
        }else{
            echo "No Result Found";
        }
    }

    public function sendBc(Request $request){
        $wa = new CurlController();
        $to = $request->input('to_siswa');
        $pesan = $request->input('pesan');

        for ($i=0; $i < count($to); $i++) { 
            $wa->bcWa(Helper::decryptUrl($to[$i]), $pesan);
        }

        return redirect()->to('bc')->with('status', 'success');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'get_jurusan' => 'required',
            'get_kelas' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $id = date('dmyHis');
        $intId = intVal($id);
        $kelas = Kelas::where('id', $request->input('get_kelas'))->first();
        if($kelas != null && $kelas->id_user == null) {
            $user->id = $intId;
            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            $user->assignRole('kelas');
            $kelas->id_user = $intId;
            $kelas->save();

            return redirect()->route('profile')->with('status', 'success');
        }
        // dd($kelas, $request->input('get_kelas'));
    //     $request->input('get_jurusan'),
   

        return redirect()->route('profile')->with('error', 'Data sudah ada');
    }
}