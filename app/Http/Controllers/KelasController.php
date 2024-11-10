<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function registerKelas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jurusan' => 'required',
            'kelas' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('kelas')->with('error', 'Data Tidak Boleh Kosong');
        }
        $validated = $validator->validated();

        $kelas = new Kelas();
        $user = new User();
        $id = date('dmyHis');
        
        $user->id = intVal($id);
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $kelas->id_sekolah = Helper::getSession();
        $kelas->id_jurusan = $request->input('jurusan');
        $kelas->kelas = $request->input('kelas');
        $user->kelas()->save($kelas);
        $user->assignRole('kelas');

        return redirect()->route('kelas')->with('status', 'sadfasd');
    }

    public function editKelas($id)
    {
        $get_jurusan = jurusan::where('id_sekolah', Helper::getSession())->get();
        // $get_kelas = Kelas::where('id', Helper::decryptUrl($id))->first();
        dd(Helper::decryptUrl($id), $get_jurusan);
    }

    public function hapusKelas($id)
    {
        $siswa = Siswa::where('id_kelas', Helper::decryptUrl($id))->get();
        if(empty($siswa[0])){
            Kelas::where('id', Helper::decryptUrl($id))->delete();
            return redirect()->route('kelas')->with('hapus', 'asdfas');
        }else{
            return redirect()->route('kelas')->with('error', 'Data Siswa Masih Ada!');
        }
        
    }
}
