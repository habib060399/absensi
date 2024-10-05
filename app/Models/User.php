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

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'id_sekolah',
        'username',
        'password'
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

    public function getUser($rfid)
    {
        $user = User::where('rfid_tag', $rfid)->first();
        return $user;
    }

    public function setUser($name, $username)
    {
        User::create([
            'name' => $name,
            'username' => $username,            
        ]);
    }

    public function updateUser($rfid, $username, $nama, $no_hp)
    {
        User::where('rfid_tag', $rfid)->update([
            'username' => $username,
            'name' => $nama,
            'no_hp' => $no_hp
        ]);
    }
    
}
