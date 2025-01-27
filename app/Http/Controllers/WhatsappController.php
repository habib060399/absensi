<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Broadcast;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Report;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index()
    {
        $array = Helper::access();
        if(in_array($this->sekolah(), $array)) {
            $report_wa = Report::where('id_sekolah', session('id_sekolah'))->get();
            return view('user.pengaturan.wa', [
                'report' => $report_wa
            ]);
        }else{
            $id_kelas = Kelas::where('id_user', session('id_user'))->select('id')->first();
            $report_wa = Report::where('id_kelas', $id_kelas->id)->get();
            return view('user.pengaturan.wa', [
                'report' => $report_wa
            ]);
        }
    }

    public function groupIndex()
    {
        $sekolah = Sekolah::where('id', session('id_sekolah'))->first();

        if(isset($sekolah->broadcast()->first()->wa_group)){
            $group = $sekolah->broadcast()->first()->wa_group;
            $serialize = serialize($group);
            $json = json_decode(unserialize($serialize));

            return view('user.pengaturan.wa_group', [
                'group_wa' => $json->data
            ]);
        }else{
            return view('user.pengaturan.wa_group',[
                'group_wa' => []
            ]);
        }

    }

    public function destroy(Request $request)
    {
        try {
            foreach ($request->id as $id){
                Report::where('id', Helper::decryptUrl($id))->delete();
            }
            $request->session()->flash('success', 'data berhasil dihapus');
            return 200;
        }catch (\Exception $e){
            return $e;
        }
    }
}
