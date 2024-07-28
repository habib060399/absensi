<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Mesin;
use App\Http\Controllers\API\CurlController;

class AdminViewController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        $getDeviceFonte= CurlController::getDevice();
        $data = json_decode($getDeviceFonte);
        
        return view('admin.home', [
            'quota' => ($data->status) ? $data->data[0]->quota : 0,
            'jml_sekolah' => Sekolah::count(),
            'jml_siswa' => Siswa::count()
        ]);
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
