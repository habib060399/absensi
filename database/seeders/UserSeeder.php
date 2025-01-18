<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sekolah;

class UserSeeder extends Seeder
{

    public function run(): void
    {

        $admin = new User();
        $admin->id = 0;
        $admin->name = 'admin';
        $admin->username = 'admin';
        $admin->password = Hash::make(123);
        $admin->save();
        $admin->assignRole('admin');

        $admin1 = new User();
        $admin1->id = 1;
        $admin1->name = '123';
        $admin1->username = '123';
        $admin1->password = Hash::make(123);
        $admin1->save();
        $admin1->assignRole('sekolah');
        $admin1->givePermissionTo('jurusan');        

        $admin1 = new User();
        $admin1->id = 2;
        $admin1->name = '321';
        $admin1->username = '321';
        $admin1->password = Hash::make(321);
        $admin1->save();
        $admin1->assignRole('kelas');
        $admin1->givePermissionTo('jurusan');        

        $admin1 = new User();
        $admin1->id = 3;
        $admin1->name = '111';
        $admin1->username = '111';
        $admin1->password = Hash::make(111);
        $admin1->save();
        $admin1->assignRole('kelas');
        $admin1->givePermissionTo('jurusan');        
    }
}
