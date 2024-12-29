<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Mesin;
use App\Helpers\Helper;
use App\Http\Controllers\API\CurlController;

class AdminViewController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        // $getDeviceFonte= CurlController::getDevice();
        // $data = json_decode($getDeviceFonte);

        return view('admin.home', [
            // 'quota' => ($data->status) ? $data->data[0]->quota : 0,
            'quota' => 0,
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

    public function editSekolah($id)
    {
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();
        // dd($sekolah, $sekolah->wa()->select('no_wa', 'token_account_wa', 'token_api_wa')->get());
        return view('admin.sekolah.edit_sekolah', [
            'sekolah' => Sekolah::where('id', Helper::decryptUrl($id))->first(),
            'wa' => $sekolah->wa()->select('no_wa', 'token_account_wa', 'token_api_wa')->first(),
            'user' => $sekolah->user()->select('username')->first()
        ]);
    }

    public function paket($id)
    {
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();

        return view('admin.paket', [
            'sekolah' => $sekolah,
            'paket' => Paket::all()
        ]);
    }
}
