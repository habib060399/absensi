<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $fillable = ['id', 'id_sekolah', 'nama_jurusan'];
    public $timestamp = true;

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id');
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'id_jurusan', 'id');
    }
}
