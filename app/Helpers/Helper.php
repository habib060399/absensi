<?php

namespace App\Helpers;

use App\Models\Paket;
use App\Models\Sekolah;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Helper
{
    public static function getSession()
    {
        return session('id_user');
    }

    public static function idSessionSekolah()
    {
        return session('id_sekolah');
    }

    public static function encryptUrl($string)
    {
        // Metode enkripsi (cipher method)
        $ciphering = "AES-128-CTR";

        // panjang vektor inisialisasi (IV)
        $iv_length = openssl_cipher_iv_length($ciphering);

        //Vektor inisialisasi (IV) untuk enkripsi
        $encryption_iv = '1234567891011121';

        // kunci enkripsi
        $encryption_key = "W3docs";

        // enkripsi data
        $encryption = openssl_encrypt($string, $ciphering, $encryption_key, 0, $encryption_iv);
        return base64_encode(strval($encryption));
    }

    public static function decryptUrl($string)
    {
        // Metode enkripsi (cipher method)
        $ciphering = "AES-128-CTR";

        // Vektor inisialisasi (IV) untuk dekripsi
        $decryption_iv = '1234567891011121';

        // Kunci dekripsi
        $decryption_key = "W3docs";

        // Dekripsi data
        $decryption = openssl_decrypt(base64_decode($string), $ciphering, $decryption_key, 0, $decryption_iv);
        return $decryption;
    }

    public function getPaket($id)
    {
        $paket = Paket::where('id', $id)->first();
        return $paket;
    }

    public static function checkUsername()
    {
        $sekolah = Sekolah::where('sekolah.id', session('id_sekolah'))->select('sekolah.id_slug_user')->first();
        $kelas = Kelas::where('id_sekolah', session('id_sekolah'))->join('users', 'kelas.id_user', '=', 'users.id')->orderBy('users.username', 'asc')->get();
        $username = null;
        for ($i = 0; $i < count($kelas); $i++){
            $username = User::where('id', $kelas[$i]['id_user'])->select('username')->first();
        }
        $get_string_last = str_replace($sekolah->id_slug_user, '', ($username) ? $username->username : "");
        return $sekolah->id_slug_user . intval($get_string_last)+1;
    }

    public static function generateNumberInv()
    {
        $id = '';
        $getLastNumber = Invoice::select('serial_number')->orderBy('serial_number', 'desc')->first();
        if(empty($getLastNumber->serial_number)){
            return "INV-0000001";
        }else{
            $number = str_replace("INV-", "", $getLastNumber->serial_number);
            $id = str_pad($number + 1, 7, 0, STR_PAD_LEFT);
        }
        return "ENV-".$id;
    }

    public static function checkPermission($name)
    {
        $user = User::where('id', session('id_user'))->first();
        return $user->hasPermissionTo($name);
    }

    public static function getSekolah($column)
    {
        $sekolah = Sekolah::where('id', session('id_sekolah'))->select($column)->first();
        return $sekolah;
    }

    public static function access()
    {
        $user = User::where('id', session('id_user'))->first();
        $roles = $user->getRoleNames()->toArray();
        $permissions = $user->getPermissionNames()->toArray();
        $array_merged = array_merge($roles, $permissions);
        return $array_merged;
    }

    public static function getAccess($idUser)
    {
        $user = User::where('id', $idUser)->first();
        $roles = $user->getRoleNames()->toArray();
        $permissions = $user->getPermissionNames()->toArray();
        $array_merged = array_merge($roles, $permissions);
        return $array_merged;
    }
}
