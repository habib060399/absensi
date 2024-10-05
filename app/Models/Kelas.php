<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['id_sekolah', 'id_jurusan', 'kelas'];
    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
