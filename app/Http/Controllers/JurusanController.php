<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        return view('user.sekolah.jurusan', ['jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get()]);
    }
}
