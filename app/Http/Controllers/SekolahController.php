<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SekolahController extends Controller
{
    public function index()
    {
        $data[] = array();
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
        $guru = $sekolah->guru()->select('nama_guru', 'jabatan', 'email as email_kepsek', 'no_wa')->first();
        $jurusan = $sekolah->jurusan()->select('nama_jurusan')->get();
        $kelas = Kelas::where('id_sekolah', $sekolah->id)->select('kelas')->get();
        $tahun_ajaran = Sekolah::where('id', session('id_sekolah'))->select('th_ajaran_awal', 'th_ajaran_akhir')->first();
        $data = array_merge($sekolah->toArray(), $guru->toArray());
        $paket = $sekolah->paket()->first();
        $serialize = serialize($paket->detail);
        $paket_json = json_decode(unserialize($serialize));

        return view('user.pengaturan.sekolah', [
            'data' => $data,
            'jurusan' => $jurusan,
            'kelas' => $kelas,
            'paket' => $paket_json->data,
            'tahun_ajaran' => $tahun_ajaran
        ]);
    }

    public function setTahunAjaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'awal_ajaran' => 'required|date|before_or_equal:akhir_ajaran',
            'akhir_ajaran' => 'required|date'
         ]);
        
         if($validator->fails()){
            $errors = $validator->errors();
            $error = "";
            foreach($errors->all() as $e){
                $error .= $e;
            }
        return redirect()->route('sekolah')->with('error', $error);        
         }

        Sekolah::where('id', session('id_sekolah'))->update([            
            'th_ajaran_awal' => $request->input('awal_ajaran'),
            'th_ajaran_akhir' => $request->input('akhir_ajaran')
        ]);
        return redirect()->route('sekolah')->with('success', 'Data berhasil ditambahkan');    
    }
}
