<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Perangkat;

class AdminController extends Controller
{
    public function registerView()
    {        
        return view('register_perangkat', ['uniqId' => Str::random(16)]);
    }

    public function createDevice(Request $request)
    {        
        $request->validate([
            'nama_sekolah' => 'required',
            'id_perangkat' => 'required|unique:App\Models\Perangkat,id_mesin|max:16'
        ]);
        
        Perangkat::create([
            'nama_sekolah' => $request->input('nama_sekolah'),
            'id_mesin' => $request->input('id_perangkat')
        ]);

        return redirect('/register-device');
    }
}
