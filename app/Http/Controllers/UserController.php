<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class UserController extends Controller
{
    public function cekAbsensi($rfid)
    {
        $absen = new Absensi();

        $date = date("d-m-Y h:i:sa");
        $absen->setAbsen($rfid, $date);

        
    }
}
