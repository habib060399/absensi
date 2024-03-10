<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function cekAbsensi($rfid)
    {
        $absen = new Absensi();
        $user = new User();
        $time_now = date("h:i:s");
        $date_now = date("d-m-Y"); 
        $get_date="";
        $get_absen_user = $absen->getAbsen($rfid);
        $get_user = $user->getUser($rfid);
            
            if($get_absen_user != null){
                foreach($get_absen_user as $a){
                    $get_date = $a->tanggal;
                }
                if($date_now == $get_date){
                    return 2;
                }else{
                    $absen->setAbsen($rfid, $date_now, $time_now, $get_user->name);
                    return 1;
                }
                // }
            }else{
                $absen->setAbsen($rfid, $date_now, $time_now, $get_user->name);
                return 1;                
            }
            // return $status;

            // return 1;
    }

    public function registerJurusan(Request $request)
    {                
        Jurusan::create([
            'id_sekolah' => Helper::getSession(),
            'nama_jurusan' => $request->input('jurusan')
        ]);

        return redirect()->route('jurusan')->with('status', 'sadf');
    }

    public function registerKelas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jurusan' => 'required',
            'kelas' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('kelas')->with('error', 'Data Tidak Boleh Kosong');
        }
        $validated = $validator->validated();

        Kelas::create([
            'id_sekolah' => Helper::getSession(),
            'id_jurusan' => $request->input('jurusan'),
            'kelas' => $request->input('kelas'),
        ]);

        return redirect()->route('kelas')->with('status', 'sadfasd');
    }

    public function editKelas($id)
    {
        $get_jurusan = jurusan::where('id_sekolah', Helper::getSession())->get();
        // $get_kelas = Kelas::where('id', Helper::decryptUrl($id))->first();
        dd(Helper::decryptUrl($id), $get_jurusan);
    }

    public function registerSiswa(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'email' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'no_hp' => 'required',
            'no_hp_ortu' => 'required',
            // 'rfid' => 'required|unique:siswa,rfid',
        ]);

        $siswa = Siswa::create([
            'id_sekolah' => $request->session()->get('id'),
            'id_jurusan' => $request->input('jurusan'),
            'id_kelas' => $request->input('kelas'),
            'nama_siswa' => $request->input('nama_siswa'),
            'rfid' => $request->input('rfid'),
            'email' => $request->input('email'),
            'no_hp' =>  $request->input('no_hp'),
            'no_hp_ortu' => $request->input('no_hp_ortu')
        ]);
        
        return redirect()->route('siswa_add')->with('status', 'asdfasdf');
    }

    public function getKelas(Request $request)
    {
        $kelas = Kelas::where('id_jurusan', $request->id_jurusan)->get();
        $get_kelas = $request->id_kelas;

        if($kelas){
                
            // echo '<option selected disabled>Pilih Kelas</option>';
            foreach ($kelas as $k) {
                if($k->id == $get_kelas){
                    echo "<option value='$k->id' selected > $k->kelas</option>";
                }

                echo "<option value='$k->id'> $k->kelas</option>";
                
            }
        }else{
            echo '<option selected disabled>Pilih Kelas</option>';
        }      
    }

    public function hapus($model, $id)
    {
        $get_model = "App\Models\\".$model;
        $get_model::where('id', Helper::decryptUrl($id))->delete();

        return redirect()->route('siswa')->with('hapus', 'asdfasd');
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

    public function hapusJurusan($id)
    {
        $kelas = Kelas::where('id_jurusan', Helper::decryptUrl($id))->get();
        if(empty($kelas[0])){
            Jurusan::where('id', Helper::decryptUrl($id))->delete();
            return redirect()->route('jurusan')->with('hapus', 'asfdas');
        }else{
            return redirect()->route('jurusan')->with('error', 'Data Jurusan Masih Ada!');
        }
    }

    public function editJurusan(Request $request)
    {
        Jurusan::where('id', $request->input('id_edit_jurusan'))->update(['nama_jurusan' => $request->input('edit_jurusan')]);
        return redirect()->route('jurusan')->with('status', 'asadf');
    }
}