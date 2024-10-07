<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wa extends Model
{
    use HasFactory;

    protected $table = 'wa';
    protected $fillable = ['no_wa', 'wa_group'];
    public $timestamps = true;
    
    public function sekolah() : HasMany {
        return $this->hasMany(Sekolah::class, 'id_wa', 'id');
    }
}
