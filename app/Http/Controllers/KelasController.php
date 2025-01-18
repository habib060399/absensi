<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\User;
use App\Enums\AuthorizationEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{

    public function index()
    {  
        $array = Helper::access();
        if(in_array($this->sekolah(), $array) && in_array($this->jurusan(), $array)){
            return view('user.sekolah.kelas', [
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get(),
                'kelas' => Kelas::join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id')->join('users', 'kelas.id_user', '=', 'users.id')->select('kelas.*', 'jurusan.nama_jurusan', 'users.username')->where('kelas.id_sekolah', session('id_sekolah'))->get(),
                'username' => Helper::checkUsername()
            ]);
        }elseif (in_array($this->sekolah(), $array)) {
            return view('user.sekolah.kelas', [
                'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get(),
                'kelas' => Kelas::join('users', 'kelas.id_user', '=', 'users.id')->select('kelas.*', 'users.username')->where('kelas.id_sekolah', session('id_sekolah'))->get(),
                'username' => Helper::checkUsername()
            ]);
        }
        
        return abort(500);
    }

    public function store(Request $request)
    {
        $user = User::where('id', session('id_user'))->first();
        if($user->can('jurusan')){
            $validator = Validator::make($request->all(), [
                'jurusan' => 'required',
                'kelas' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'kelas' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required'
            ]);
        }        

        try {
            DB::beginTransaction();
            $kelas = new Kelas();
            $user = new User();
            $sekolah = Sekolah::where('id', session('id_sekolah'))->first();
            $id = date('dmyHis');

            $user->id = intVal($id);
            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->expiry_date = $sekolah->user()->first()->expiry_date;
            $user->save();

            $kelas->id_sekolah = session('id_sekolah');
            $kelas->id_jurusan = $request->input('jurusan');
            $kelas->kelas = $request->input('kelas');
            $user->kelas()->save($kelas);
            $user->assignRole('kelas');            

            DB::commit();
            return redirect()->route('kelas')->with('success', 'Berhasil Menambahkan Kelas');
        }catch (\Exception $e){
            // dd($e);
            DB::rollBack();
            return redirect()->route('kelas')->with('error', 'Data gagal disimpan');
        }
    }

    public function edit($id, Request $request)
    {        
        Helper::decryptUrl($id);
        $kelas = Kelas::where('id', Helper::decryptUrl($id))->select('*')->first();

        return view('user.sekolah.edit_kelas', [
            'kelas' => $kelas,
            'user' => $kelas->user,
            'jurusan' => jurusan::where('id_sekolah', session('id_sekolah'))->get()
        ]);
    }

    public function update($id, Request $request)
    {
        $id_kelas = Helper::decryptUrl($id);
        $get_kelas = Kelas::where('id_sekolah', Helper::getSession())->where('id', $id_kelas)->first();

        try {
            DB::beginTransaction();

            // $user = User::where('id', session('id_user'))->first();
            if(User::checkPermission('jurusan sekolah')){
                $get_kelas->id_jurusan = Helper::decryptUrl($request->input('jurusan'));
            }

            $pass = $request->input('password');
            $get_kelas->kelas = $request->input('kelas');
            $get_kelas->user->username = $request->input('username');
            $get_kelas->save();

            if($pass != null){
                $get_kelas->user->password = Hash::make($pass);
                $get_kelas->user->save();
            }

            DB::commit();
            return redirect()->route('kelas')->with('success', 'Berhasil Mengubah Kelas');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('kelas')->with('error', 'Data gagal diubah');
        }
    }

    public function delete($id)
    {
        $siswa = Siswa::where('id_kelas', Helper::decryptUrl($id))->get();
        if(empty($siswa[0])){
            Kelas::where('id', Helper::decryptUrl($id))->delete();
            return redirect()->route('kelas')->with('hapus', 'asdfas');
        }else{
            return redirect()->route('kelas')->with('error', 'Data Siswa Masih Ada!');
        }

    }

    public function getAllKelas(Request $request)
    {   
        $array = Helper::access();
        $param1 = '';
        $param2 = '';
        if(in_array($this->sekolah(), $array) || in_array($this->jurusan(), $array)){
            $param1 = 'id_sekolah';
            $param2 = session('id_sekolah');
        }elseif (in_array($this->kelas(), $array)) {
            $param1 = 'id_user';
            $param2 = session('id_user');
        }
        
        $kelas = Kelas::where($param1, $param2)->get();
        $get_kelas = $request->id_kelas;
        $get_jurusan = $request->id_jurusan;
        $selected = '';

        if($kelas){
            echo "<option selected disabled>Pilih Kelas</option>";            
            foreach ($kelas as $k) {
                
                echo "<option value='$k->id'> $k->kelas</option>";                

            }
        }else{
            echo '<option selected disabled>Pilih Kelas</option>';            
        }
    }

    public function getKelasById(Request $request)
    {
        $kelas = null;
        $array = Helper::access();

        if(in_array($this->sekolah(), $array) && in_array($this->jurusan(), $array)){            
            $kelas = Kelas::where('id_jurusan', $request->id_jurusan)->get();
        }elseif (in_array($this->sekolah(), $array)) {
            $kelas = Kelas::where('id_sekolah', session('id_sekolah'))->get();
        }

        if($kelas != null){
            echo "<option selected disabled>Pilih Kelas</option>";
            foreach ($kelas as $k) {
                $selected = ($k->id == $request->id_kelas) ? 'selected' : '';
                echo "<option value='$k->id' $selected> $k->kelas</option>";
            }
        }else{
            echo "Tidak ada data atau data failed";
        }
    }
}
