<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $permission3 = Permission::create(['name' => 'message wa']);
        $permission4 = Permission::create(['name' => 'sms']);
        Permission::create(['name' => 'jurusan']);
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $role2 = Role::create([
            'name' => 'sekolah',
            'guard_name' => 'web'
            ]);

        $role = Role::create([
            'name' => 'kelas',
            ]);
        
        $permission3->syncRoles($role2);
        $permission3->syncRoles($role);
        $permission4->syncRoles($role2);
        $permission4->syncRoles($role);        
    }
}
