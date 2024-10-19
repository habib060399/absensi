<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Jabatan;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::where('guru.id_sekolah', session('id_sekolah'))->join('jabatan', 'guru.id_jabatan', '=', 'jabatan.id')->select('guru.id', 'nama_guru', 'nama_jabatan', 'no_wa')->get();
        return view('user.sekolah.guru', [
            'guru' => $guru
        ]);
    }

    public function showEditGuru($id)
    {
        $guru = Guru::where('id', Helper::decryptUrl($id))->first();
        $get_jabatan = Jabatan::where('id_sekolah', session('id_sekolah'))->where('id', $guru->id_jabatan)->first();
        return view('user.sekolah.edit_guru', [
            'guru' => $guru,
            'jabatan' => Jabatan::where('id_sekolah', session('id_sekolah'))->get(),
            'get_jabatan' => ($get_jabatan) ? $get_jabatan->id : " "
        ]);
    }

    public function showInsertGuru()
    {
        return view('user.sekolah.tambah_guru',[
            'jabatan' => Jabatan::where('id_sekolah', session('id_sekolah'))->get()
        ]);
    }

    public function insertGuru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_guru' => 'required',
            'no_wa' => 'required'
        ]);

        $foto = $request->file('foto');
        if($foto != null){
            $request->validate([
                'foto' => 'image|max:2000'
            ]);

            if($validator->fails()){
                return redirect()->route('guru')->with('error', 'File bukan format gambar !');
            }

            $filename = Carbon::now()->format('YmdHis') . '.' . $foto->getClientOriginalExtension();
            Guru::create([
                'id_sekolah' => session('id_sekolah'),
                'nama_guru' => $request->input('nama_guru'),
                'no_wa' => $request->input('no_wa'),
                'id_jabatan' => $request->input('jabatan'),
                'email' => $request->input('email'),
                'foto' => $filename
            ]);
            $foto->storePubliclyAs('foto_guru', $filename);
            return redirect()->route('guru')->with('status', 'asdf');
        }else{
            Guru::create([
                'id_sekolah' => session('id_sekolah'),
                'nama_guru' => $request->input('nama_guru'),
                'no_wa' => $request->input('no_wa'),
                'id_jabatan' => $request->input('jabatan'),
                'email' => $request->input('email')
            ]);

            return redirect()->route('guru')->with('status', 'asdf');
        }
        return redirect()->route('guru')->with('error', 'Data gagal ditambahkan');                
    }

    public function editGuru(Request $request, $id)
    {
        Helper::decryptUrl($id);
        $foto = $request->file('foto');
        if($foto != null){
            $validator = Validator::make($request->all(), [
               'foto' => 'image|max:2000'
            ]);

            if($validator->fails()){
                return redirect()->route('guru')->with('error', 'File bukan format gambar !');
            }

            $get_guru = Guru::where('id', Helper::decryptUrl($id))->first();
            Storage::delete('foto_guru/'.$get_guru->foto);
            $filename = Carbon::now()->format('YmdHis') . '.' . $foto->getClientOriginalExtension();
            Guru::where('id', Helper::decryptUrl($id))->update([
                'nama_guru' => $request->input('nama_guru'),
                'no_wa' => $request->input('no_wa'),
                'id_jabatan' => $request->input('jabatan'),
                'foto' => $filename,
                'email' => $request->input('email')
            ]);
            $foto->storePubliclyAs('foto_guru', $filename);
            return redirect()->route('guru')->with('status', 'asdf');
        }else{
            Guru::where('id', Helper::decryptUrl($id))->update([
                'nama_guru' => $request->input('nama_guru'),
                'no_wa' => $request->input('no_wa'),
                'id_jabatan' => $request->input('jabatan'),
                'email' => $request->input('email')
            ]);

            return redirect()->route('guru')->with('status', 'asdf');
        }
        return redirect()->route('guru')->with('error', 'Data gagal ditambahkan');
    }

    public function deleteGuru($id)
    {
        $guru = Guru::where('id', Helper::decryptUrl($id))->first();
        if($guru){
            if(isset($guru->foto)){
                Storage::delete('foto_guru/'.$guru->foto);
            }
            Guru::where('id', Helper::decryptUrl($id))->delete();

            return redirect()->route('guru')->with('hapus', 'asdfasd');
        }

        return redirect()->route('guru')->with('hapus', 'asdfasd');
    }

    public function insertJabatan(Request $request)
    {
        Jabatan::create([
            'id_sekolah' => session('id_sekolah'),
            'nama_jabatan' => $request->input('nama_jabatan')
        ]);

        return redirect()->route('guru')->with('status', 'Daasdfg');
    }
}
