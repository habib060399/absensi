<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class UserKelasController extends Controller
{
    public function index()
    {
        return view('user.pengaturan.profile', [
            'jurusan' => jurusan::where('id_sekolah', Helper::getSession())->get()
        ]);
    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function create()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
