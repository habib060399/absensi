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
        $permission = Permission::create(['name' => 'only class']);
        $permission2 = Permission::create(['name' => 'admin sekolah']);
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

        $permission->syncRoles($role);
        $permission2->syncRoles($role2);
    }
}
