<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Guru;
use App\Enums\AuthorizationEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $array = Helper::access();
        if(in_array($this->jurusan(), $array) && in_array($this->sekolah(), $array)) {
            return view('user.sekolah.siswa', [
                'siswa' => Siswa::join('jurusan', 'siswa.id_jurusan', '=', 'jurusan.id')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->select('siswa.*', 'jurusan.nama_jurusan', 'kelas.kelas')->where('siswa.id_sekolah', Helper::idSessionSekolah())->get(),
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get()
            ]);
        }elseif (User::checkRole('kelas') && User::checkPermission('jurusan')) {
            $kelas = Kelas::where('id_user', session('id_user'))->first();
            $siswa = Siswa::join('jurusan', 'siswa.id_jurusan', '=', 'jurusan.id')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->select('siswa.*', 'jurusan.nama_jurusan', 'kelas.kelas')->where('siswa.id_sekolah', session('id'))->where('siswa.id_kelas', $kelas->id)->get();
            return view('user.sekolah.siswa', [
                'siswa' => $siswa,
                'kelas' => $kelas,
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get(),
                'get_jurusan' => jurusan::where('id', $kelas->id_jurusan)->first()
            ]);
        }elseif(User::checkRole('sekolah')){
            // $siswa = Siswa::join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->where('kelas.id_sekolah', session('id_sekolah'))->select('siswa.*', 'kelas.kelas')->get();
            return view('user.sekolah.siswa', [
                'siswa' => Siswa::join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->where('kelas.id_sekolah', session('id_sekolah'))->select('siswa.*', 'kelas.kelas')->get(),
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get()
            ]);
        }else{
            return view('user.sekolah.siswa', [
                'siswa' => Siswa::join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->where('kelas.id_user', session('id_user'))->select('siswa.*', 'kelas.kelas')->get(),
                'kelas' => Kelas::where('id_user', session('id_user'))->first(),
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get()
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'email' => 'required',
            (Helper::checkPermission('jurusan')) ? "'jurusan_sekolah' => 'required'," : "'jurusan_sekolah' => true",
//            'jurusan_sekolah' => 'required',
            'kelas_sekolah' => 'required',
            'no_hp' => 'required',
            'no_hp_ortu' => 'required',
//            'rfid' => 'required|unique:siswa,rfid',
            'foto' => 'image|max:2000'
        ]);

        $foto = $request->file('foto');
        $id = $request->session()->get('id_sekolah');
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();

        if(!empty($foto)){
            $filename = Carbon::now()->format('YmdHis') . '.' . $foto->getClientOriginalExtension();
            $foto->storePubliclyAs('foto', $filename);

            if(Siswa::checkLimit($sekolah->limit_siswa, ['id_sekolah' => $id])){
                return redirect()->route("siswa")->with("error", "Data Siswa sudah mencapai limit !");
            }else{
                $siswa = Siswa::create([
                    'id_sekolah' => $id,
                    'id_jurusan' => $request->input('jurusan_sekolah'),
                    'id_kelas' => $request->input('kelas_sekolah'),
                    'nama_siswa' => $request->input('nama_siswa'),
                    'rfid' => $request->input('rfid'),
                    'email' => $request->input('email'),
                    'no_hp' =>  $request->input('no_hp'),
                    'no_hp_ortu' => $request->input('no_hp_ortu'),
                    'foto' => $filename
                ]);

                return redirect()->route('siswa_add')->with('success', 'Berhasil Menambahkan Siswa');
            }
        }else{
            if(Siswa::checkLimit($sekolah->limit_siswa, ['id_sekolah' => $id])){
                return redirect()->route("siswa")->with("error", "Data Siswa sudah mencapai limit !");
            }else{
                $siswa = Siswa::create([
                    'id_sekolah' => $id,
                    'id_jurusan' => $request->input('jurusan_sekolah'),
                    'id_kelas' => $request->input('kelas_sekolah'),
                    'nama_siswa' => $request->input('nama_siswa'),
                    'rfid' => $request->input('rfid'),
                    'email' => $request->input('email'),
                    'no_hp' =>  $request->input('no_hp'),
                    'no_hp_ortu' => $request->input('no_hp_ortu'),
                ]);

                return redirect()->route('siswa_add')->with('success', 'Berhasil Menambahkan Siswa');
            }
        }
    }

    public function show()
    {

    }

    public function create()
    {

    }

    public function edit($id)
    {
        $siswa = Siswa::where('id', Helper::decryptUrl($id))->first();
        $kelas = Kelas::where('id', $siswa->id_kelas)->first();
        // dd($siswa);
        return view('user.sekolah.edit_siswa',[
            'siswa' => $siswa,
            'kelas' => $kelas,
            'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get(),
        ]);
    }

    public function update($id, Request $request)
    {
        if (Helper::checkPermission('jurusan')){
            $request->validate([
                'nama_siswa' => 'required',
                'email' => 'required',
                'jurusan' => 'required',
                'kelas' => 'required',
                'no_hp' => 'required',
                'no_hp_ortu' => 'required',
            ]);
        }else{
            $request->validate([
                'nama_siswa' => 'required',
                'email' => 'required',
                'kelas' => 'required',
                'no_hp' => 'required',
                'no_hp_ortu' => 'required',
            ]);
        }

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

    public function destroy($id)
    {
        $get_siswa = Siswa::where('id', Helper::decryptUrl($id))->first();

        Storage::delete('foto/'.$get_siswa->foto);
        Siswa::where('id', Helper::decryptUrl($id))->delete();

        return redirect()->route('siswa')->with('hapus', 'asdfasd');
    }

    public function getSiswaByDate(Request $request)
    {
        try {
            $request->validate([
                'id_kelas' => 'required',
                'tgl_mulai' => 'required|date|before_or_equal:tgl_selesai',
                'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai'
            ]);

            $array = Helper::access();
            if((in_array($this->sekolah(), $array) || in_array($this->kelas(), $array)) && in_array($this->jurusan(), $array)){
                $data = array();
                $no = 1;
                $siswa = Siswa::join('jurusan', 'siswa.id_jurusan', '=', 'jurusan.id')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->where('siswa.id_kelas', $request->id_kelas)->select('siswa.nama_siswa', 'siswa.rfid', 'siswa.id', 'kelas.kelas', 'jurusan.nama_jurusan')->get();

                foreach ($siswa as $s) {
                    $data[] = array(
                        'no' => $no++,
                        'nama_siswa' => $s->nama_siswa,
                        'hadir' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->whereBetween('tanggal', [$request->tgl_mulai, $request->tgl_selesai])->where('status', 'hadir')->where('id_siswa', $s->id)->count('status'),
                        'absen' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'absen')->where('id_siswa', $s->id)->count('status'),
                        'izin' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'izin')->where('id_siswa', $s->id)->count('status'),
                        'sakit' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'sakit')->where('id_siswa', $s->id)->count('status'),
                        'kelas' => $s->kelas,
                        'jurusan' => $s->nama_jurusan,
                        'link' => array(route('editSiswa', ['id' => Helper::encryptUrl($s->id)]), route('hapus', ['id' => Helper::encryptUrl($s->id)])),
                        'tgl' => $request->tgl_mulai
                    );
                }
                return json_encode($data);
            }elseif (in_array($this->sekolah(), $array) || in_array($this->kelas(), $array)) {

                $data = array();
                $no = 1;
                $siswa = Siswa::join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->where('siswa.id_kelas', $request->id_kelas)->select('siswa.nama_siswa', 'siswa.rfid', 'siswa.id', 'kelas.kelas')->get();

                foreach ($siswa as $s) {
                    $data[] = array(
                        'no' => $no++,
                        'nama_siswa' => $s->nama_siswa,
                        'hadir' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->whereBetween('tanggal', [$request->tgl_mulai, $request->tgl_selesai])->where('status', 'hadir')->where('id_siswa', $s->id)->count('status'),
                        'absen' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'absen')->where('id_siswa', $s->id)->count('status'),
                        'izin' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'izin')->where('id_siswa', $s->id)->count('status'),
                        'sakit' => $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'sakit')->where('id_siswa', $s->id)->count('status'),
                        'kelas' => $s->kelas,
                        'link' => array(route('editSiswa', ['id' => Helper::encryptUrl($s->id)]), route('hapus', ['id' => Helper::encryptUrl($s->id)])),
                        'tgl' => $request->tgl_mulai
                    );
                }
                return json_encode($data);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'kosong']);
        }
    }

    public function findContact(Request $request)
{
    $access = Helper::access();

    $query = Siswa::query();

    // Filter jurusan
    if ((in_array($this->sekolah(), $access) || in_array($this->kelas(), $access)) && in_array($this->jurusan(), $access)) {
        $query->where(
            'id_jurusan',
            Helper::decryptUrl($request->id_jurusan)
        );
    }

    // Filter kelas
    if (in_array($this->sekolah(), $access) || in_array($this->kelas(), $access)) {
        $query->where('id_kelas', $request->id_kelas);
    }

    $siswa = $query->select('nama_siswa AS nama', 'no_hp', 'no_hp_ortu')->get();

    $guru = Guru::where('id_sekolah', session('id_sekolah'))->select('nama_guru AS nama', 'no_wa AS no_hp')->get();

    $sekolah = Sekolah::find(session('id_sekolah'));

    $groups = [];

    if ($sekolah?->broadcast?->wa_group) {
        $groups = json_decode($sekolah->broadcast->wa_group);
    }

    $options = [];
    
         switch ($request->selected) {
            case 'ortu':
                foreach ($siswa as $item) {
                    $options[] = [
                        'label' => "Ortu " . $item->nama,
                        'value' => Helper::encryptUrl($item->no_hp_ortu)
                    ];
                }                
                break;
            case 'siswa':
                foreach ($siswa as $item) {
                    $options[] = [
                        'label' => $item->nama,
                        'value' => Helper::encryptUrl($item->no_hp)
                    ];
                }                
                break;
            case 'guru':                
                foreach ($guru as $item) {
                    $options[] = [
                        'label' => $item->nama,
                        'value' => Helper::encryptUrl($item->no_hp)
                    ];
                 }
                break;
            default:
                foreach ($guru as $item) {
                    $options[] = [
                        'label' => $item->nama,
                        'value' => Helper::encryptUrl($item->no_hp)
                    ];
                 }
                foreach ($siswa as $item) {
                    $options[] = [
                        'label' => $item->nama,
                        'value' => Helper::encryptUrl($item->no_hp)
                    ];
                }
                break;
        }

    // Group
    if (!empty($groups->data)) {

        foreach ($groups->data as $group) {

            $options[] = [
                'label' => $group->name,
                'value' => Helper::encryptUrl($group->id)
            ];
        }
    }

    return response()->json($options);
}

}
