<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\Report;
use Illuminate\Support\Facades\Log;

class CurlController extends Controller
{
    public function setApiWa(array $param) {
        $sekolah = Sekolah::where('sekolah.id', (session('id_sekolah')) ? session('id_sekolah') : session('id'))->join('broadcast', 'sekolah.id_wa', '=', 'broadcast.id')->select('token_account_wa', 'token_api_wa')->first();
        // (!empty($sekolah->token_api_wa)) ? $sekolah->token_api_wa : " ";
        $token = $sekolah->token_api_wa;

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
        $res = json_decode($responseWa, true);
        foreach ($res['id'] as $k=>$v){
            $target = $res['target'][$k];
            $status = $res['process'];
            Report::create([
                'id' => $v,
                'target' => $target,
                'message' => $param['message'],
                'status' => $status
            ]);
        }

        if(isset($error_msg)){
            return $error_msg;
        }
        Log::info('ini response Whatssap'.$responseWa);
        return $responseWa;
    }

    public function sendWaAbsenManual($no, $nama_siswa, $id_sekolah, $message)
    {
        $bc = preg_replace("/{nama}/", "$nama_siswa", $message);
        $data = array(
            'target' => $no,
            'message' => "$bc",
            'countryCode' => "62"
        );

        return $status = $this->setApiWa($data);
    }

    public function sendPresencenWa($no, $nama_siswa, $id_sekolah)
    {
        $sekolah = Sekolah::where('id', $id_sekolah)->first();
        $teks = $sekolah->broadcast()->first()->template_bc;
        $json = serialize($teks);
        $unserialize = unserialize($json);
        $decode = json_decode($unserialize);

        $bc = preg_replace("/{nama}/", "$nama_siswa", $decode->data[0]->message);
        $token = $sekolah->broadcast()->first()->token_api_wa;

        $curl = curl_init();
        $data = array(
            'target' => $no,
            'message' => "$bc",
            'countryCode' => "62"
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
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
        $sekolah = Sekolah::where('sekolah.id', (session('id_sekolah')) ? session('id_sekolah') : session('id'))->join('broadcast', 'sekolah.id_wa', '=', 'broadcast.id')->select('token_account_wa', 'token_api_wa')->first();
        $token = $sekolah->token_account_wa;
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
