<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view patients',
            'add patients',
            'edit patients',
            'delete patients',
            'create invoice',
            'manage users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $branchAdminRole = Role::firstOrCreate(['name' => 'Branch Admin']);

        $adminRole->givePermissionTo($permissions);
        $branchAdminRole->givePermissionTo([
            'view patients',
            'add patients',
            'edit patients',
            'create invoice'
        ]);

        $adminUser = \App\Models\User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }
    }
}
