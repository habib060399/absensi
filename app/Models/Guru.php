<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $fillable = ['id_sekolah', 'id_jabatan', 'nama_guru', 'no_wa', 'foto', 'email'];
    public $timestamp = true;
}
