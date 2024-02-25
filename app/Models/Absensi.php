<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'id_siswa',
        'name',
        'tanggal',
        'waktu'
    ];

    public $timestamps = false;

    public function setAbsen($rfid, $date, $time, $name)
    {
        Absensi::create([
            'rfid_tag' => $rfid,
            'tanggal'=> $date,
            'waktu' => $time,
            'name' => $name
        ]);
    }

    public function getAll()
    {
        $absen = Absensi::all();
        return $absen;
    }
    
    public function getTime($rfid, $date)
    {
        $absen = Absensi::where('rfid_tag', $rfid)->where('tanggal', $date)->get();
        return $absen;
    }

    public function getAbsen($rfid)
    {
        $absen = Absensi::where('rfid_tag', $rfid)->get();
        return $absen;
    }
}
