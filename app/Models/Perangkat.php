<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $table = 'perangkat';
    protected $fillable = ['id_mesin', 'nama_sekolah'];
    public $timestamps = false;
}
