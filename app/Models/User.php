<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'rfid_tag',
        'no_hp'
    ];

    public $timestamps = false;

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
