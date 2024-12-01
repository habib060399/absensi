<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Wa;
use App\Models\Sekolah;
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
        $id = date('dmyHis');    
        Jurusan::create([
            'id' => intval($id),
            'id_sekolah' => session('id_sekolah'),
            'nama_jurusan' => $request->input('jurusan')
        ]);

        return redirect()->route('jurusan')->with('success', 'Berhasil Menambah Jurusan');
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
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
        $id = date('dmyHis');
        
        $user->id = intVal($id);
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->expiry_date = $sekolah->user()->first()->expiry_date;
        $user->save();

        $kelas->id_sekolah = session('id_sekolah');
        $kelas->id_jurusan = $request->input('jurusan');
        $kelas->kelas = $request->input('kelas');
        $user->kelas()->save($kelas);
        $user->assignRole('kelas');
        $user->givePermissionTo('only class');

        return redirect()->route('kelas')->with('success', 'Berhasil Menambahkan Kelas');
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
        return redirect()->route('kelas')->with('success', 'Berhasil Mengubah Kelas');
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
        
        return redirect()->route('siswa_add')->with('success', 'Berhasil Menambahkan Siswa');
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
    
            return redirect()->route('siswa')->with('success', 'Berhasil Mengubah Data Siswa');
        }else{
            Siswa::where('id', Helper::decryptUrl($id))->update([
                'nama_siswa' => $request->input('nama_siswa'),
                'email' => $request->input('email'),
                'id_jurusan' => $request->input('jurusan'),
                'id_kelas' => $request->input('kelas'),
                'no_hp' => $request->input('no_hp'),
                'no_hp_ortu' => $request->input('no_hp_ortu')
            ]);
    
            return redirect()->route('siswa')->with('success', 'Berhasil Mengubah Data Siswa');
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
            $kelas = Kelas::where('id', Helper::decryptUrl($id))->first();
            $kelas->user()->delete();
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
        return redirect()->route('jurusan')->with('success', 'Berhasil Mengubah Jurusan');
    }

    public function editPesan(Request $request)
    {
        
        $hadir = $request->input('broadcast-hadir');
        $sakit = $request->input('broadcast-sakit');
        $izin = $request->input('broadcast-izin');
        $absen = $request->input('broadcast-absen');
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
        // $teks = "{"data":[{"title":"hadir","message":$hadir},{"title":"sakit","message":$sakit},{"title":"absen","message":$absen},{"title":"izin","message":$izin}]}";
        $teks = $sekolah->wa()->first()->template_bc;
        $json = serialize($teks);
        $unserialize = unserialize($json);
        $decode = json_decode($unserialize);
        $decode->data[0]->message = $hadir;        
        $decode->data[1]->message = $sakit;        
        $decode->data[2]->message = $absen;        
        $decode->data[3]->message = $izin;        
        $sekolah->wa()->update([
            'template_bc' => json_encode($decode)
        ]);
        
        return redirect()->route('pesan')->with('success', 'Berhasil Mengubah Pesan');
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
            $teks = $sekolah->wa()->first()->template_bc;
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

    public function delAbsen($id, $tanggal){
        // dd($id, $tanggal);
        Absensi::where('id_siswa', $id)->where('tanggal', $tanggal)->delete();

        return redirect()->route('absen')->with('hapus', 'asdf');
    }

    public function editAbsen(Request $request){
        $absen = Absensi::where('id_siswa', $request->id_siswa)->where('tanggal', $request->tanggal)->first();
        $status = ["hadir", "izin", "sakit"];
        $string ="";        

        foreach($status as $s) {
         if($s == $absen->status){
            echo "<option selected disabled>$s</option>";
         }
         echo "<option value='$s'>$s</option>";
        }
    }

    public function insertEditAbsen(Request $request){

        // Absensi::where('id_siswa', $request->id)->where('tanggal', $request->tanggal)->update(['status' => $request->status]);
        $curl = new CurlController();
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
        $teks = $sekolah->wa()->first()->template_bc;
        $json = serialize($teks);
        $unserialize = unserialize($json);
        $decode = json_decode($unserialize);
            
            switch ($request->status) {
                case 'hadir':                    
                $get_siswa = Siswa::where('id', $request->id)->first();
                $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, "*INFORMASI ULANG* \n\n".$decode->data[0]->message."\n".Carbon::now());
                Absensi::where('id_siswa', $request->id)->where('tanggal', $request->tanggal)->update(['status' => $request->status]);

                    return response()->json([
                        'url' => route('absen'),
                        'status' => 200,
                        'message' => 'data berhasil ditambahkan'
                    ]);
                    break;
                case 'absen':                    
                    $get_siswa = Siswa::where('id', $request->id)->first();
                    $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, "*INFORMASI ULANG* \n\n".$decode->data[2]->message."\n".Carbon::now());
                    Absensi::where('id_siswa', $request->id)->where('tanggal', $request->tanggal)->update(['status' => $request->status]);                    
                    
                    return response()->json([
                        'url' => route('absen'),
                        'status' => 200,
                        'message' => 'data berhasil ditambahkan'
                    ]);
                    break;
                case 'izin':                    
                    $get_siswa = Siswa::where('id', $request->id)->first();
                    $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, "*INFORMASI ULANG* \n\n".$decode->data[3]->message."\n".Carbon::now());
                    Absensi::where('id_siswa', $request->id)->where('tanggal', $request->tanggal)->update(['status' => $request->status]);                    
                    
                    return response()->json([
                        'url' => route('absen'),
                        'status' => 200,
                        'message' => 'data berhasil ditambahkan'
                    ]);
                    break;
                case 'sakit':                                           
                    $get_siswa = Siswa::where('id', $request->id)->first();
                    $curl->sendWaAbsenManual($get_siswa->no_hp_ortu, $get_siswa->nama_siswa, $get_siswa->id_sekolah, "*INFORMASI ULANG* \n\n".$decode->data[1]->message."\n".Carbon::now());
                    Absensi::where('id_siswa', $request->id)->where('tanggal', $request->tanggal)->update(['status' => $request->status]);                    
                    
                    return response()->json([
                        'url' => route('absen'),
                        'status' => 200,
                        'message' => 'data berhasil ditambahkan'
                    ]);
                    break;
                default:
                return redirect()->route('absen')->with('error', 'status tidak boleh kosong');
                    break;
            }

        session(['success' => 'data berhasil ditambahkan']);
        return response()->json([
            'url' => route('absen'),
            'status' => 200,
            'message' => 'data berhasil ditambahkan'
        ]);
    }

    public function exportTemplateSiswa(Request $request) {
        $jurusan = $request->input('jurusan_sekolah');
        $kelas = $request->input('kelas_sekolah');
        $siswa = $request->input('jml_siswa');
        if(!empty($jurusan) && !empty($kelas)){
            return Excel::download(new TemplateDaftarSiswa($jurusan, $kelas, $siswa), "template-daftar-siswa.xlsx");
        }
        return back()->with('error', 'Data Tidak boleh Kosong');
    }

    public function importSiswa(Request $request) {
        $request->validate([
            'file' => 'required|max:2048'
        ]);

        try {
            $file = Excel::import(new SiswaImport, $request->file('file'));
            return back()->with('success', 'Berhasil Mengimport Data');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }                

        // return back()->with('success', 'Berhasil Mengimport Data');
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
        $user = User::where('id', session('id_user'))->first();                      
        $siswa = Siswa::where('id_jurusan', $request->id_jurusan)->where('id_kelas', $request->id_kelas)->select('nama_siswa AS nama', 'no_hp', 'no_hp_ortu')->get()->toArray();
        $guru = Guru::where('id_sekolah', ($user->can('only class')) ?  session('id') : session('id_sekolah'))->select('nama_guru AS nama', 'no_wa AS no_hp')->get()->toArray();
        $sekolah = Sekolah::where('id', ($user->can('only class')) ?  session('id') : session('id_sekolah'))->first();
        $serilize = serialize($sekolah->wa->wa_group);
        $unserilize = unserialize($serilize);
        $a = json_decode($unserilize);              
        $data = [
            'siswa' => $siswa,
            'guru' => $guru,
            'group' => $a
        ];
        
        if($data){
            if($request->selected == "ortu"){
                for($i = 0; $i < count($data['siswa']); $i++){
                    if($data['siswa'][$i]['no_hp_ortu']){
                        echo "<option value=".Helper::encryptUrl($data['siswa'][$i]['no_hp_ortu'])." selected> Ortu ".$data['siswa'][$i]['nama']."</option>";
                    }
                }

                if(!empty($data['guru'])){
                    for($i = 0; $i < count($data['guru']); $i++){
                        echo "<option value=".Helper::encryptUrl($data['guru'][$i]['no_hp']).">".$data['guru'][$i]['nama']."</option>";
                    }
                }

                if (!empty($data['group'])) {
                    for($i = 0; $i < count($data['group']->data); $i++){
                        echo "<option value=".Helper::encryptUrl($data['group']->data[$i]->id).">".$data['group']->data[$i]->name."</option>";
                    }
                }                    
            }elseif ($request->selected == "siswa") {
                for($i = 0; $i < count($data['siswa']); $i++){
                if($data['siswa'][$i]['no_hp']){
                    echo "<option value=".Helper::encryptUrl($data['siswa'][$i]['no_hp'])." selected>".$data['siswa'][$i]['nama']."</option>";
                }                
            }

            if(!empty($data['guru'])){
                for($i = 0; $i < count($data['guru']); $i++){
                    echo "<option value=".Helper::encryptUrl($data['guru'][$i]['no_hp']).">".$data['guru'][$i]['nama']."</option>";
                }
            }

            if (!empty($data['group'])) {
                for($i = 0; $i < count($data['group']->data); $i++){
                    echo "<option value=".Helper::encryptUrl($data['group']->data[$i]->id).">".$data['group']->data[$i]->name."</option>";
                }
            }       
            }else{
                for($i = 0; $i < count($data['siswa']); $i++){
                    echo "<option value=".Helper::encryptUrl($data['siswa'][$i]['no_hp']).">".$data['siswa'][$i]['nama']."</option>";
                }

                if(!empty($data['guru'])){
                    for($i = 0; $i < count($data['guru']); $i++){
                        echo "<option value=".Helper::encryptUrl($data['guru'][$i]['no_hp']).">".$data['guru'][$i]['nama']."</option>";
                    }
                }

                if (!empty($data['group'])) {
                    for($i = 0; $i < count($data['group']->data); $i++){
                        echo "<option value=".Helper::encryptUrl($data['group']->data[$i]->id).">".$data['group']->data[$i]->name."</option>";
                    }
                }
            }
        }else{
            echo "Data Kosong";
        }
        
    }

    public function sendBc(Request $request)
    {
        $request->validate([
            'to_siswa' => 'required',
            'pesan' => 'required',
            'files' => 'file|image|max:5000'
        ]);
        $wa = new CurlController();
        $get_file = $request->file('file');
        $to = $request->input('to_siswa');
        $pesan = $request->input('pesan');
        $tgl = $request->input('tgl');
        $waktu = $request->input('waktu');
        $gabung = $tgl ." ".$waktu;
        $unix_time = strtotime($gabung);                

        if(!empty($get_file)){
            $filename = $get_file->getClientOriginalName();
            $get_file->storePubliclyAs('tmp', $filename);

            $filepath = storage_path("app/public/tmp/".$filename);
            if(file_exists($filepath)){                
                for ($i=0; $i < count($to); $i++) { 
                $wa->bcWaWithFile(Helper::decryptUrl($to[$i]), $pesan, $filepath, $unix_time);
                }
                return redirect()->route('bc')->with('success', 'success');
            }
        }elseif(empty($get_file)){
            for ($i=0; $i < count($to); $i++) { 
            $wa->bcWa(Helper::decryptUrl($to[$i]), $pesan, $unix_time);
            }
            return redirect()->route('bc')->with('success', 'success');
        }

        return redirect()->route('bc');
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

            return redirect()->route('profile')->with('success', 'success');
        }
        
        return redirect()->route('profile')->with('error', 'Data sudah ada');
    }

    public function registerWa(Request $request)
    {
        $no = $request->input('no_wa');
        $wa = new Wa();
        $user = User::where('id', Helper::getSession())->first();

        $id = date('dmyHis');

        if( $user->getRoleNames()->first() == "sekolah"){
            $wa->id = $id;
            $wa->no_wa = $request->input('no_wa');
            Sekolah::where('id_user', $user->id)->update([
                'id_wa' => $id
            ]);
            $wa->save();
            return redirect()->route('wa')->with('success', 'Berhasil Menambahkan Nomor Whatssap');
        }
        return redirect()->route('wa')->with('error', 'Data gagal ditambahkan');
    }

    public function updateGroupWa()
    {
        $get = CurlController::updateGroupWa();
        $grup = CurlController::getGroupWa();
        // $data = file_get_contents($get);
        $getJson = json_decode($get, true);
        $getJson2 = json_decode($grup, true);
        $sekolah = Sekolah::where('id_user', Helper::getSession())->first();
        $sekolah->wa()->update([
            'wa_group' => $grup
        ]);

        return redirect()->route('wa')->with('status', 'Data gagal ditambahkan');
    }
}