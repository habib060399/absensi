<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'rfid_tag',
        'name',
        'tgl_waktu',
    ];

    public $timestamps = false;

    public function setAbsen($rfid, $dateTime)
    {
        Absensi::create([
            'rfid_tag' => $rfid,
            'tgl_waktu'=> $dateTime
        ]);
    }

    public function getAbsen($rfid)
    {
        $absen = Absensi::where('rfid_tag', $rfid)->firts();
        return $absen;
    }
}
