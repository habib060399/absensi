<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Guru;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $data[] = array();
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
        $guru = $sekolah->guru()->select('nama_guru', 'jabatan', 'email as email_kepsek', 'no_wa')->first();
        $jurusan = $sekolah->jurusan()->select('nama_jurusan')->get();
        $kelas = Kelas::where('id_sekolah', $sekolah->id)->select('kelas')->get();
        $data = array_merge($sekolah->toArray(), $guru->toArray());
        $paket = $sekolah->paket()->first();
        $serialize = serialize($paket->detail);
        $paket_json = json_decode(unserialize($serialize));

        return view('user.pengaturan.sekolah', [
            'data' => $data,
            'jurusan' => $jurusan,
            'kelas' => $kelas,
            'paket' => $paket_json->data,
        ]);
    }
}
