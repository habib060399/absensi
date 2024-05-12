<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class CurlController extends Controller
{
    public function curlWa($no, $nama_siswa, $id_sekolah)
    {
        // $token = "G2QL_4v@aa!zSH7VHrSk";
        $token = env("TOKEN_API_WA");
        $getSekolah = Settings::where('id_sekolah', $id_sekolah)->first();
        $bc = preg_replace("/{nama}/", "$nama_siswa", $getSekolah->bc);
        // 0859106701927


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $no,
                'message' => "$bc",
                'countryCode' => '62'
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            )
        ));

        $responseWa = curl_exec($curl);
        curl_close($curl);

        return $responseWa;
    }
}