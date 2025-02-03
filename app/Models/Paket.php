<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';
    protected $fillable = ['nama_paket', 'max_user', 'active', 'price', 'detail'];
    public $timestamps = true;

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class, 'id_paket', 'id');
    }
}
