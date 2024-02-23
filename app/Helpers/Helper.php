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
}