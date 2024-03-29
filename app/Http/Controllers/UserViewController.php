<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Cookie;

class UserViewController extends Controller
{
    public function jurusan()
    {
        return view('user.jurusan', ['jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()]);
    }

    public function editJurusan($id)
    {
        $get_jurusan = Jurusan::where('id', Helper::decryptUrl($id))->first();
        return $get_jurusan;
    }

    public function kelas()
    {
        return view('user.kelas', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
            'kelas' => Kelas::join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id')->select('kelas.*', 'jurusan.nama_jurusan')->where('kelas.id_sekolah', Helper::getSession())->get()
        ]);
    }

    public function editKelas($id)
    {
        Helper::decryptUrl($id);
        
        return view('user.edit_kelas', [
            'kelas' => Kelas::where('id', Helper::decryptUrl($id))->first(),
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()
        ]);
    }

    public function siswa()
    {
        // return view('user.siswa', ['kelas' => Kelas::where('id_sekolah', Helper::getSession())->get()]);
        return view('user.siswa', ['siswa' => Siswa::join('jurusan', 'siswa.id_jurusan', '=', 'jurusan.id')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->select('siswa.*', 'jurusan.nama_jurusan', 'kelas.kelas')->where('siswa.id_sekolah', Helper::getSession())->get()]);
    }

    public function editSiswa($id)
    {
        return view('user.edit_siswa',[
            'siswa' => Siswa::where('id', Helper::decryptUrl($id))->first(),
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),            
        ]);
    }

    public function addSiswa()
    {
        // return Helper::getCookie();
        return view('user.tambah_siswa', ['cookies' => Cookie::get('id_mesin'), 'jurusan' => jurusan::where('id_sekolah', session('id'))->get()]);
    }

    public function broadcast()
    {
        return view('user.broadcast', ['broadcast' => Settings::where('id_sekolah',session('id'))->first(), 'id_sekolah' => session('id')]);
    }
}
