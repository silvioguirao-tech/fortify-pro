<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissões
        $permissions = [
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        // Atribuir permissões
        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['user.view', 'user.edit']);
    }
}
