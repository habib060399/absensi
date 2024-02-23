<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Mesin;
use App\Models\Sekolah;

class ControllerView extends Controller
{
    protected $mesin;

    public function __construct()
    {
        $this->mesin = new Mesin();
    }

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

    public function dataMesin()
    {        
        return view('data_mesin', ['uniqId' => Str::random(16), 'mesin' => $this->mesin->get()]);
    }

    public function dataSekolah()
    {
        return view('daftar_sekolah', ['sekolah' => Sekolah::get()]);
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
