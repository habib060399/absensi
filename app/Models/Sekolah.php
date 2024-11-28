<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wa;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $fillable = ['id_user', 'id_wa', 'nama_sekolah', 'email', 'id_mesin', 'pendidikan', 'npsn'];
    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function wa(): BelongsTo
    {
        return $this->belongsTo(Wa::class, 'id_wa', 'id');
    }

    public function jurusan(): HasMany
    {
        return $this->hasMany(Jurusan::class, 'id_sekolah', 'id');
    }

    public function guru(): HasMany
    {
        return $this->hasMany(Guru::class, 'id_sekolah', 'id');
    }
}
