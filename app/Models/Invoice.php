<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $fillable = ['id_paket', 'id_sekolah', 'total', 'detail', 'serial_number'];
    public $timestamps = true;

}
