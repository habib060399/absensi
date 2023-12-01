<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;

class UserController extends Controller
{
    public function cekAbsensi($rfid)
    {
        $absen = new Absensi();
        $user = new User();
        $time_now = date("h:i:s");
        $date_now = date("d-m-Y"); 
        $get_date="";
        $get_absen_user = $absen->getAbsen($rfid);
        $get_user = $user->getUser($rfid);
            
            if($get_absen_user != null){
                foreach($get_absen_user as $a){
                    $get_date = $a->tanggal;
                }
                if($date_now == $get_date){
                    return 2;
                }else{
                    $absen->setAbsen($rfid, $date_now, $time_now, $get_user->name);
                    return 1;
                }
                // }
            }else{
                $absen->setAbsen($rfid, $date_now, $time_now, $get_user->name);
                return 1;                
            }
            // return $status;

            // return 1;

    }
}