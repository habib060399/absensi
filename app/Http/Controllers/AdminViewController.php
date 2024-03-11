<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sekolah;
use App\Models\Mesin;

class AdminViewController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        return view('home');
    }

    public function dataAbsen()
    {
        return view('data_absen');
    }

    public function mesin()
    {        
        return view('admin.mesin.index', ['uniqId' => Str::random(16), 'mesin' => Mesin::get()]);
    }

    public function sekolah()
    {
        return view('admin.sekolah.daftar_sekolah', ['sekolah' => Sekolah::get()]);
    }
    
    public function registerView()
    {        
        return view('register_perangkat', ['uniqId' => Str::random(16)]);
    }

    public function loginDeviceView()
    {        
        return view('login_device');
    }

    public function addSekolah()
    {
        return view('tambah_sekolah', ['mesin' => $this->mesin->where('status', 'Not Used')->get()]);
    }
}
