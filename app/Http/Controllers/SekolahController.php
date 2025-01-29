<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Guru;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
        $guru = Guru::where('id_sekolah', session('id_sekolah'))->get();
        dd($guru);
        return view('user.pengaturan.sekolah', [
            'sekolah' => $sekolah
        ]);
    }
}
