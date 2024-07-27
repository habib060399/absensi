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
        'waktu',
        'status'
    ];

    public $timestamps = false;

    public function siswa() {
        return $this->hasMany(Siswa::class, 'id_siswa', 'id');
    }

}
