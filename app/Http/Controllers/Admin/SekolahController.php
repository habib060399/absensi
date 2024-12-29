<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\Invoice;
use App\Models\Kelas;
use App\Models\Mesin;
use App\Models\Paket;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Broadcast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SekolahController extends Controller
{
    protected $sekolahModel;
    protected $userModel;
    protected $waModel;
    protected $invoiceModel;

    public function __construct()
    {
        $this->sekolahModel = new Sekolah();
        $this->userModel = new User();
        $this->waModel = new Broadcast();
        $this->invoiceModel = new Invoice();
    }

    public function index()
    {
        $sekolah = Sekolah::join('paket', 'sekolah.id_paket', '=', 'paket.id')->join('users', 'sekolah.id_user', '=', 'users.id')->select('nama_sekolah', 'npsn', 'email', 'pendidikan', 'nama_paket', 'expiry_date', 'sekolah.id')->get();
        return view('admin.sekolah.daftar_sekolah', [
            'sekolah' => $sekolah
        ]);
    }

    public function wizard()
    {
        return view('admin.sekolah.tambah_sekolah_new', [
            'paket' => Paket::all(),
            'mesin' => Mesin::where('status', 'Not Used')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required',
            'email' => 'required',
            'id_mesin' => 'required',
            'pendidikan' => 'required',
            'npsn' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'slug' => 'required',
            'contact' => 'required',
            'paket' => 'required'
        ]);

        $id = date('dmyHis');
        $idMesin = $request->input('id_mesin');
        $paket = $request->input('paket');
        $totalSiswa = $request->input('jml_siswa');
        $jurusan = $request->input('check_jurusan');
        $totalPrice = 0;
        $getPaket = Paket::where('id', $paket)->select('*')->first();
        $activePeriod = Carbon::now()->addMonths($getPaket->active);

        try {
            DB::beginTransaction();

            $this->userModel->id = intVal($id);
            $this->userModel->username = $request->input('username');
            $this->userModel->password = Hash::make($request->input('password'));
            $this->userModel->expiry_date = $activePeriod;
            $this->userModel->save();

            $this->waModel->id = intVal($id);
            $this->waModel->save();

            $this->sekolahModel->id = intVal($id);
            $this->sekolahModel->nama_sekolah = $request->input('nama_sekolah');
            $this->sekolahModel->email = $request->input('email');
            $this->sekolahModel->id_mesin = $idMesin;
            $this->sekolahModel->pendidikan = $request->input('pendidikan') ;
            $this->sekolahModel->no_hp = $request->input('contact') ;
            $this->sekolahModel->npsn = $request->input('npsn');
            $this->sekolahModel->id_slug_user = $request->input('slug');
            $this->sekolahModel->id_wa = intVal($id);
            $this->sekolahModel->id_paket = $getPaket->id;

            $this->invoiceModel->id_paket = $getPaket->id;
            $this->invoiceModel->id_sekolah = intVal($id);
            $this->invoiceModel->nama_paket = $getPaket->nama_paket;
            $this->invoiceModel->kuantiti = $getPaket->siswa;
            $this->invoiceModel->harga = $getPaket->price;
            $this->invoiceModel->paket_detail = $getPaket->detail;
            if($getPaket->type == 'unit'){
                $totalPrice = intVal($totalSiswa) * intVal($getPaket->price);
                $this->invoiceModel->jml_siswa = $totalSiswa;
                $this->sekolahModel->limit_siswa = $totalSiswa;
                $this->invoiceModel->total = $totalPrice;
            }else{
                $this->sekolahModel->limit_siswa = $getPaket->siswa;
                $this->invoiceModel->jml_siswa = $getPaket->siswa;
                $this->invoiceModel->total = $getPaket->price;
            }
            $this->invoiceModel->save();
            $this->userModel->sekolah()->save($this->sekolahModel);

            $this->userModel->givePermissionTo('admin sekolah');
            if($jurusan == "true"){
                $this->userModel->givePermissionTo('jurusan sekolah');
            }

            switch ($getPaket->nama_paket){
                case 'B':
                    $this->userModel->givePermissionTo('message wa');
                    break;
                case 'C':
                    $this->userModel->givePermissionTo('message wa');
                    $this->userModel->givePermissionTo('sms');
                    break;
            }
            $this->userModel->assignRole('sekolah');

            Mesin::where('id', $idMesin)
                ->update(['status' => 'Used']);

            DB::commit();

            return redirect()->route('sekolah')->with('success', 'Data berhasil ditambahkan');
        }catch (\Exception $e){
            dd($e);
            DB::rollBack();
            return redirect()->route('sekolah')->with('error', 'Data gagal disimpan');
        }

    }

    public function edit($id)
    {
        $sekolah = Sekolah::where('sekolah.id', Helper::decryptUrl($id))->join('mesin', 'sekolah.id_mesin', '=', 'mesin.id')->join('paket', 'sekolah.id_paket', '=', 'paket.id')->select('sekolah.*', 'mesin.id_mesin', 'paket.nama_paket')->first();
        $paket = Paket::where('id', $sekolah->id_paket)->select('detail')->first();
        $paketSerialize = serialize($paket->detail);
        $paketUnserialize = unserialize($paketSerialize);
        $jsonPaket = json_decode($paketUnserialize);

        return view('admin.sekolah.edit_sekolah', [
            'sekolah' => $sekolah,
            'wa' => $sekolah->broadcast()->select('token_account_wa', 'token_api_wa')->first(),
            'user' => $sekolah->user()->select('username')->first(),
            'paket' => Paket::all('id', 'nama_paket'),
            'paket_detail' => $jsonPaket->data
        ]);
    }

    public function update ($id, Request $request)
    {
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();
        $username = $request->input('username');
        $password = $request->input('password');
        $token_api_wa = $request->input('token_api_wa');
        $token_akun_wa = $request->input('token_akun_wa');

//        dd($jurusan);

//        Sekolah::where('id', Helper::decryptUrl($id))->update([
//            'nama_sekolah' => $request->input('nama_sekolah'),
//            'email' => $request->input('email'),
//            'npsn' => $request->input('npsn'),
//            'contact' => $request->input('contact'),
//        ]);

         $user = User::where('id', $sekolah->id_user)->first();
         dd($user);

    }

    public function delete($id)
    {
        $siswa = Siswa::where('id_sekolah', Helper::decryptUrl($id))->delete();
        $kelas = Kelas::where('id_sekolah', Helper::decryptUrl($id))->join('users', 'users.id', '=', 'kelas.id_user')->get();
        for ($i=0; $i < count($kelas); $i++) {
            $user = User::where('id', $kelas[$i]['id_user'])->first();
            $user->removeRole('kelas');
            $user->delete();
        }
        Kelas::where('id_sekolah', Helper::decryptUrl($id))->delete();
        $user = User::where('id', $id)->first();
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();
        $sekolah->guru()->delete();
        $sekolah->jurusan()->delete();
        $sekolah->broadcast()->delete();
        $user->removeRole('sekolah');
        $sekolah->user()->delete();

        return redirect()->route('sekolah')->with('hapus', 'asdfasdfsad');
    }
}
