<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Perangkat;
use App\Models\Mesin;
use App\Models\Sekolah;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Broadcast;
use App\Helpers\Helper;
use App\Http\Controllers\API\RfidController;
use Carbon\Carbon;
use PHPUnit\TextUI\Help;

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
            'password' => 'required',
            'slug' => 'required',
            'contact' => 'required',
            'paket' => 'required'
        ]);

        $sekolah = new Sekolah();
        $user = new User();
        $wa = new Broadcast();
        $invoice = new Invoice();
        $id = date('dmyHis');
        $id_mesin = $request->input('id_mesin');
        $paket = $request->input('paket');
        $total_siswa = $request->input('jml_siswa');
        $total_price = 0;
        $get_paket = Paket::where('id', $paket)->select('*')->first();

        $get_masa_aktif = Carbon::now()->addMonths($get_paket->active);

        $user->id = intVal($id);
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->expiry_date = $get_masa_aktif;
        $user->save();

        $wa->id = intVal($id);
        $wa->no_wa = $request->input('contact');
        $wa->save();

        $sekolah->id = intVal($id);
        $sekolah->nama_sekolah = $request->input('nama_sekolah');
        $sekolah->email = $request->input('email');
        $sekolah->id_mesin = $id_mesin;
        $sekolah->pendidikan = $request->input('pendidikan') ;
        $sekolah->npsn = $request->input('npsn');
        $sekolah->id_slug_user = $request->input('slug');
        $sekolah->id_wa = intVal($id);
        $sekolah->id_paket = $get_paket->id;
        $sekolah->limit_siswa = $total_siswa;
        $user->sekolah()->save($sekolah);

        if($get_paket->type == 'unit'){
            $total_price = intVal($total_siswa) * intVal($get_paket->price);

            $invoice->id_paket = $get_paket->id;
            $invoice->id_sekolah = intVal($id);
            $invoice->nama_paket = $get_paket->nama_paket;
            $invoice->jml_siswa = $total_siswa;
            $invoice->kuantiti = $get_paket->siswa;
            $invoice->harga = $get_paket->price;
            $invoice->total = $total_price;
            $invoice->paket_detail = $get_paket->detail;
            $invoice->save();
        }else{
            $invoice->id_paket = $get_paket->id;
            $invoice->id_sekolah = intVal($id);
            $invoice->nama_paket = $get_paket->nama_paket;
            $invoice->jml_siswa = $get_paket->siswa;
            $invoice->kuantiti = 1;
            $invoice->harga = $get_paket->price;
            $invoice->total = $get_paket->price;
            $invoice->paket_detail = $get_paket->detail;
            $invoice->save();
        }

        $user->assignRole('sekolah');
        $user->givePermissionTo('admin sekolah');

        Mesin::where('id', $id_mesin)
        ->update(['status' => 'Used']);

        return redirect()->route('sekolah')->with('success', 'Data Berhasil ditambahkan');
    }

    public function hapusSekolah($id)
    {
        $siswa = Siswa::where('id_sekolah', Helper::decryptUrl($id))->delete();
        $kelas = Kelas::where('id_sekolah', Helper::decryptUrl($id))->join('users', 'users.id', '=', 'kelas.id_user')->get();
        for ($i=0; $i < count($kelas); $i++) {
            User::where('id', $kelas[$i]['id_user'])->delete();
        }
        Kelas::where('id_sekolah', Helper::decryptUrl($id))->delete();
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();
        $sekolah->guru()->delete();
        $sekolah->jurusan()->delete();
        $sekolah->broadcast()->delete();
        $sekolah->user()->delete();

        return redirect()->route('sekolah')->with('hapus', 'asdfasdfsad');
    }

    public function editSekolah($id, Request $request)
    {
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();
        $date = Carbon::parse(strval($sekolah->user()->first()->expiry_date));
        $interval = Carbon::now()->diffInHours($sekolah->user()->first()->expiry_date);
        $expired_new = Carbon::parse($sekolah->user()->first()->expiry_date)->addMonths(1)->addHours($interval);
        // $addDaysDate = Carbon::now()->addDays(1);
        $addMonthDate = Carbon::now()->addMonths(1);

        // $sekolah->user()->first()->update(['expiry_date'=> $addMonthDate]);

        $nama_sekolah = $request->input('nama_sekolah');
        $email = $request->input('email');
        $id_mesin = $request->input('id_mesin');
        $pendidikan = $request->input('pendidikan');
        $npsn = $request->input('npsn');
        $contact = $request->input('contact');
        $username = $request->input('username');
        $password = $request->input('password');
        $token_api_wa = $request->input('token_api_wa');
        $paket = $request->input('paket');
        $token_akun_wa = $request->input('token_akun_wa');

        dd($sekolah->user()->first()->expiry_date, $addMonthDate, $interval, $expired_new); 

        switch ($paket) {
            case 'bronze':

                $sekolah->user()->first()->update(['expiry_date'=> $date->addMonths(3)]);
                break;
            case 'silver':
                # code...
                break;
            case 'gold':
                # code...
                break;

            default:
                # code...
                break;
        }

    }

    public function registerPaket($id, $paket)
    {
        $sekolah = Sekolah::where('id', Helper::decryptUrl($id))->first();
        $user_kelas = Kelas::where('id_sekolah', Helper::decryptUrl($id))->select('id_user')->get();
        $get_paket = Paket::where('id', Helper::decryptUrl($paket))->first();
        $interval = Carbon::now()->diffInHours($sekolah->user()->first()->expiry_date);

        if($get_paket->nama_paket){
            $expired_new = Carbon::parse($sekolah->user()->first()->expiry_date)->addMonths($get_paket->active)->addHours($interval);
            $sekolah->user()->first()->update(['expiry_date'=> $expired_new]);
            $sekolah->update(['paket' => $get_paket->nama_paket]);
            if($user_kelas){
                for ($i=0; $i < count($user_kelas); $i++) {
                    User::where('id', $user_kelas[$i]->id_user)->update([
                        'expiry_date' => $expired_new
                    ]);
                }
            }
            return redirect()->route('sekolah')->with('success', 'Paket '. $get_paket->nama_paket. " berhasil");
        }
        return back();
    }
}
