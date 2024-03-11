<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\Mesin;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authUser(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        if(Auth::attempt(['username' => $username, 'password' => $password])) {
            $get_user = User::where('username', $username)->first();            
            $sekolah = $get_user->sekolah;           
            
            $request->session()->regenerate();
            if($sekolah){
                $get_mesin = Mesin::where('id', $sekolah->id_mesin)->first();                
                Cookie::queue(Cookie::make('id_mesin', $get_mesin->id_mesin));

                $request->session()->put('id', $sekolah->id);
                $request->session()->put('nama', $sekolah->nama_sekolah);
            }else{                                          
                $request->session()->put('id', $get_user->id);
            }

            return redirect()->intended('/flockbase/home');
        }

        return back()->withErrors([
            'username' => 'Password atau Username salah'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Cookie::forget('id_mesin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
