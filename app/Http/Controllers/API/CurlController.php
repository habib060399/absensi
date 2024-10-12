<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class CurlController extends Controller
{
    public function setApiWa(array $param) {
        $token = env("TOKEN_API_WA");
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
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            )
        ));

        $responseWa = curl_exec($curl);
        if(curl_errno($curl)){
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if(isset($error_msg)){
            return $error_msg;
        }

        return $responseWa;
    }

    public function curlWa($no, $nama_siswa, $id_sekolah)
    {
        $getSekolah = Settings::where('id_sekolah', $id_sekolah)->first();
        $bc = preg_replace("/{nama}/", "$nama_siswa", $getSekolah->bc);

        $data = array(
            'target' => $no,
            'message' => "$bc",
            'countryCode' => "62"
        );

        return $status = $this->setApiWa($data);
    }

    public function bcWa($no, $pesan, $time){
        $data = array(
            'target' => $no,
            'message' => "$pesan",
            'countryCode' => "62",
            'schedule' => $time,
        );
        return $status = $this->setApiWa($data);
    }

    public function bcWaWithFile($no, $pesan, $pathFile, $time)
    {
        $data = array(
            'target' => $no,
            'message' => "$pesan",
            'countryCode' => "62",
            'file' => new \CURLFile("$pathFile"),
            'schedule' => $time,
        );
        return $status = $this->setApiWa($data);
    }

    public static function getDevice()
    {
        $token = env("TOKEN_ACCOUNT_WA");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/get-devices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
              "Authorization: $token"
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          return $response;
    }

    public static function getGroupWa()
    {
        $token = env("TOKEN_API_WA");
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/get-whatsapp-group',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function updateGroupWa()
    {
        $token = env("TOKEN_API_WA");
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/fetch-group',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}