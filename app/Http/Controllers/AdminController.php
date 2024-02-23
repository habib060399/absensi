<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Perangkat;
use App\Models\Mesin;
use App\Models\Sekolah;
use App\Models\User;
use App\Http\Controllers\API\RfidController;

class AdminController extends Controller
{    

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

    public function loginDevice(Request $request)
    {        
        $request->validate([
            'id_perangkat' => 'required|max:16'
        ]);

        $rfid = new RfidController();
        $id_perangkat = $request->input('id_perangkat');
        $get_perangkat = Perangkat::where('id_mesin', $id_perangkat)->leftJoin('personal_access_tokens', 'perangkat.id_mesin', '=', 'personal_access_tokens.name')->select('perangkat.*', 'personal_access_tokens.token')->first();
        
        if($get_perangkat){
            if($get_perangkat->token == null){
                $token = $get_perangkat->createToken($id_perangkat, ['token:check'])->plainTextToken;             
            }else{
                return redirect('/login_device');
            }
        }else{
            return redirect('/login_device');
        }                                                    
    }

    public function registerMesin(Request $request)
    {
        $db_mesin = new Mesin();
        $id_mesin = $request->input('id_mesin');
        $total = $request->input('total');

        if($total == "1"){
            $db_mesin->create([
                'id_mesin' => $id_mesin
            ]);
        }else{
            for ($i=0; $i < (int)$total; $i++) {
                $db_mesin->create([
                    'id_mesin' => Str::random(16)
                ]);                
            }
        }

        return redirect()->route('mesin')->with('status', 'title-icon-text-footer');
    }

    public function registerSekolah(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required',
            'email' => 'required',
            'id_mesin' => 'required',
            'pendidikan' => 'required',
            'npsn' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);

        $id_mesin = $request->input('id_mesin');

        $getIdLast = Sekolah::orderBy('id', 'desc')->first();
        $id = $getIdLast->id + 1;

        $user = new User();
        $user->id = $id;
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $sekolah = new Sekolah();
        $sekolah->nama_sekolah = $request->input('nama_sekolah');
        $sekolah->email = $request->input('email');
        $sekolah->id_mesin = $id_mesin;
        $sekolah->pendidikan = $request->input('pendidikan') ;
        $sekolah->npsn = $request->input('npsn');
        $user->sekolah()->save($sekolah);
        
        $user->assignRole('sekolah');

        Mesin::where('id', $id_mesin)
        ->update(['status' => 'Used']);

        return redirect()->route('sekolah')->with('status', 'asdfasdfsad');
    } 
}
