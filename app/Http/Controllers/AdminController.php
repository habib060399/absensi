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

    public function loginDeviceView()
    {        
        return view('login_device');
    }

    public function loginDevice(Request $request)
    {
        $request->validate([
            'id_perangkat' => 'required|max:16'
        ]);

        $id_perangkat = $request->input('id_perangkat');
        $get_perangkat = Perangkat::where('id_mesin', $id_perangkat)->first();

        if ($get_perangkat) {
            $token = $get_perangkat->createToken('token');
            dd($token->plainTextToken);
        }
    }
}
