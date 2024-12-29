<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;

    protected $table = 'broadcast';
    protected $fillable = ['wa_group', 'id_sekolah', 'template_bc'];
    public $timestamps = true;

    public function sekolah() : HasMany {
        return $this->hasMany(Sekolah::class, 'id_wa', 'id');
    }
}
