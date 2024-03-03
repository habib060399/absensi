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
        $chipering = "AES-128-CTR";

        // panjang vektor inisialisasi (IV)
        $iv_length = openssl_cipher_iv_length($chipering);

        //Vektor inisialisasi (IV) untuk enkripsi
        $encryption_iv = '1234567891011121';

        // kunci enkripsi
        $encryption_key = "W3docs";

        // enkripsi data
        $encryption = openssl_encrypt($string, $chipering, $encryption_key, 0, $encryption_iv);
        return $encryption;
    }
}