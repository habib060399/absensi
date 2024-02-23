<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jurusan;
use App\Models\Kelas;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Cookie;

class UserViewController extends Controller
{
    public function jurusan()
    {
        return view('user.jurusan', ['jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()]);
    }

    public function kelas()
    {
        return view('user.kelas', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get(),
            'kelas' => Kelas::where('kelas.id_sekolah', Helper::getSession())->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id')->get()
        ]);
    }

    public function siswa()
    {
        return view('user.siswa', ['kelas' => Kelas::where('id_sekolah', Helper::getSession())->get()]);
    }

    public function addSiswa()
    {
        // return Helper::getCookie();
        return view('user.tambah_siswa', ['cookies' => Cookie::get('id_mesin')]);
    }
}
