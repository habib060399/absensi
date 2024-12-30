<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Sekolah;
use App\Models\Kelas;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'id_sekolah',
        'username',
        'password',
        'expiry_date'
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;

    public function sekolah()
    {
        return $this->hasOne(Sekolah::class, 'id_user', 'id');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_user', 'id');
    }

    public function isActive()
    {
        return $this->expiry_date && Carbon::now()->lessThanOrEqualTo($this->expiry_date);
    }

    public static function checkRole($name)
    {
        $user = User::where('id', session('id_user'))->first();        
        return $user->hasRole($name);
    }

    public static function checkPermission($name)
    {
        $user = User::where('id', session('id_user'))->first();
        return $user->hasPermissionTo($name);
    }
}
