<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        if(Helper::checkPermission('jurusan sekolah')) {
            return view('user.sekolah.siswa', [
                'siswa' => Siswa::join('jurusan', 'siswa.id_jurusan', '=', 'jurusan.id')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->select('siswa.*', 'jurusan.nama_jurusan', 'kelas.kelas')->where('siswa.id_sekolah', Helper::idSessionSekolah())->get(),
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get()
            ]);
        }else{
            return view('user.sekolah.siswa', [
                'siswa' => Siswa::join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->select('siswa.*', 'kelas.kelas')->where('siswa.id_sekolah', session('id_sekolah'))->get(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'email' => 'required',
            (Helper::checkPermission('jurusan sekolah')) ? "'jurusan_sekolah' => 'required'," : null,
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
        return view('user.sekolah.edit_siswa',[
            'siswa' => $siswa,
            'kelas' => $kelas,
            'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get(),
        ]);
    }

    public function update($id, Request $request)
    {
        if (Helper::checkPermission('jurusan sekolah')){
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
}
