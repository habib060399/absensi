<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Helper
{
    public static function getSession()
    {   
        return session('id');
    }

    public static function getCookie()
    {
        return "Ini Cookie";
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
        return strval($encryption);
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
        $decryption = openssl_decrypt($string, $ciphering, $decryption_key, 0, $decryption_iv);
        return $decryption;
    }
}