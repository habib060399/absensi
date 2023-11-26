<?php

namespace App\Http\Controllers\APi;

use Illuminate\Http\Request;

class CurlContorller extends Controller
{
    public function curlWa(Request $request)
    {
        $token = "M@h1JoXPN4WV12JrKv-g";
        $target = "082169376803";

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
                'target' => $target,
                'message' => "$_POST[rfid] telah hadir di sekolah",
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