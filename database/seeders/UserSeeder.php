<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sekolah;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $sekolah = User::create([
        //     'name' => 'SMK PANCA BUDI MEDAN',
        //     'username' => 'smkpancabudi',
        //     'password' => Hash::make(123)
        // ]);

        // $sekolah->assignRole('sekolah');
        
        $admin = new User();
        $admin->id = 0;
        $admin->name = 'admin';
        $admin->username = 'admin';
        $admin->password = Hash::make(123);
        $admin->save();

        // $admin = User::create([
        //     'id' => 0,
        //     'name' => 'admin',
        //     'username' => 'admin',
        //     'password' => Hash::make(123)
        // ]);

        // Sekolah::create([
        //     'id_mesin' => 'wertw',
        //     'nama_sekolah' => 'gdfhfgdh',
        //     'email' => 'fdgsdf',
        //     'pendidikan' => 'sadfsd',
        //     'npsn' => 'sadf',
        // ]);

        $admin->assignRole('admin');
    }
}
