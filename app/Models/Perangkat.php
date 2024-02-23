<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Perangkat extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'perangkat';
    protected $fillable = ['id_mesin', 'nama_sekolah'];
    public $timestamps = false;
}
