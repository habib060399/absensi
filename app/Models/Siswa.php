<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = ['nama_siswa', 'id_sekolah', 'id_jurusan', 'id_kelas', 'rfid', 'foto', 'no_hp', 'no_hp_ortu', 'email'];
}
