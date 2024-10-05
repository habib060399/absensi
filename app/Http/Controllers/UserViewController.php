<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Cookie;

class UserViewController extends Controller
{
    public function jurusan()
    {
        return view('user.sekolah.jurusan', ['jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()]);
    }

    public function editJurusan($id)
    {
        $get_jurusan = Jurusan::where('id', Helper::decryptUrl($id))->first();
        return $get_jurusan;
    }

    public function kelas()
    {
        return view('user.sekolah.kelas', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
            'kelas' => Kelas::join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id')->select('kelas.*', 'jurusan.nama_jurusan')->where('kelas.id_sekolah', Helper::getSession())->get()
        ]);
    }

    public function editKelas($id)
    {
        Helper::decryptUrl($id);
        $kelas = Kelas::where('id', Helper::decryptUrl($id))->select('*')->first();
        
        return view('user.sekolah.edit_kelas', [
            'kelas' => $kelas,
            'user' => $kelas->user,
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()
        ]);
    }

    public function siswa()
    {
        // return view('user.siswa', ['kelas' => Kelas::where('id_sekolah', Helper::getSession())->get()]);
        return view('user.sekolah.siswa', ['siswa' => Siswa::join('jurusan', 'siswa.id_jurusan', '=', 'jurusan.id')->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')->select('siswa.*', 'jurusan.nama_jurusan', 'kelas.kelas')->where('siswa.id_sekolah', Helper::getSession())->get()]);
    }

    public function editSiswa($id)
    {
        $siswa = Siswa::where('id', Helper::decryptUrl($id))->first();
        $kelas = Kelas::where('id', $siswa->id_kelas)->first();
        return view('user.sekolah.edit_siswa',[
            'siswa' => $siswa,
            'kelas' => $kelas,
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),            
        ]);
    }

    public function addSiswa()
    {
        return view('user.sekolah.tambah_siswa', ['cookies' => Cookie::get('id_mesin'), 'jurusan' => jurusan::where('id_sekolah', session('id'))->get()]);
    }

    public function pesan()
    {
        $setting = Settings::where('id_sekolah',session('id'))->first();
        return view('user.broadcast', ['broadcast' => ($setting) ? $setting->bc : "", 'id_sekolah' => session('id')]);
    }

    public function absen()
    {
        $user = User::where('id', session('id_user'))->first();
        if($user){
            if($user->can('only class')){
                return view('user.absen.data_absen', [
                    'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->where('id', $user->kelas->id_jurusan)->select('nama_jurusan')->first(),
                    'kelas' => $user->kelas
                ]);
            }
        }

        return view('user.absen.data_absen', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
        ]);
    }

    public function liveAbsen()
    {
        $user = User::where('id', session('id_user'))->first();
        if($user){
            if($user->can('only class')){
                return view('user.absen.absensi_live', [
                    'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->where('id', $user->kelas->id_jurusan)->select('nama_jurusan')->first(),
                    'cookies' => Cookie::get('id_mesin'),
                    'kelas' => $user->kelas
                ]);
            }
        }

        return view('user.absen.absensi_live', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
            'cookies' => Cookie::get('id_mesin')
        ]);
    }

    public function profile() {
        return view('user.pengaturan.profile', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()
        ]);
    }

    // public function kirimPesan() {
    //     return view('user.kirim_pesan', [
    //         'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
    //     ]);
    // }

    public function broadcast() {
        $user = User::where('id', session('id_user'))->first();
        if($user){
            if($user->can('only class')){
                return view('user.kirim_pesan', [
                    'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->where('id', $user->kelas->id_jurusan)->select('nama_jurusan')->first(),                    
                    'kelas' => $user->kelas,                    
                ]);
            }
        }

        return view('user.kirim_pesan', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
        ]);
    }

    public function home() {
        return view('user.index');
    }

    public function rekapAbsen() {
        $user = User::where('id', session('id_user'))->first();
        if($user){
            if($user->can('only class')){
                // $jurusan = jurusan::where('id_sekolah', Helper::getSession())->where('id', $user->kelas->id_jurusan)->select('nama_jurusan')->first();
                // dd($jurusan);
                return view('user.absen.rekap_absen', [
                    'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->where('id', $user->kelas->id_jurusan)->select('nama_jurusan')->first(),
                    'kelas' => $user->kelas
                ]);
            }
        }

        return view('user.absen.rekap_absen', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
        ]);
    }
}
