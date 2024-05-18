<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list databases']);
        Permission::create(['name' => 'view databases']);
        Permission::create(['name' => 'create databases']);
        Permission::create(['name' => 'update databases']);
        Permission::create(['name' => 'delete databases']);

        Permission::create(['name' => 'list domains']);
        Permission::create(['name' => 'view domains']);
        Permission::create(['name' => 'create domains']);
        Permission::create(['name' => 'update domains']);
        Permission::create(['name' => 'delete domains']);

        Permission::create(['name' => 'list emailaccounts']);
        Permission::create(['name' => 'view emailaccounts']);
        Permission::create(['name' => 'create emailaccounts']);
        Permission::create(['name' => 'update emailaccounts']);
        Permission::create(['name' => 'delete emailaccounts']);

        Permission::create(['name' => 'list ftpaccounts']);
        Permission::create(['name' => 'view ftpaccounts']);
        Permission::create(['name' => 'create ftpaccounts']);
        Permission::create(['name' => 'update ftpaccounts']);
        Permission::create(['name' => 'delete ftpaccounts']);

        Permission::create(['name' => 'list sshaccesses']);
        Permission::create(['name' => 'view sshaccesses']);
        Permission::create(['name' => 'create sshaccesses']);
        Permission::create(['name' => 'update sshaccesses']);
        Permission::create(['name' => 'delete sshaccesses']);

        Permission::create(['name' => 'list technologies']);
        Permission::create(['name' => 'view technologies']);
        Permission::create(['name' => 'create technologies']);
        Permission::create(['name' => 'update technologies']);
        Permission::create(['name' => 'delete technologies']);

        Permission::create(['name' => 'list techversions']);
        Permission::create(['name' => 'view techversions']);
        Permission::create(['name' => 'create techversions']);
        Permission::create(['name' => 'update techversions']);
        Permission::create(['name' => 'delete techversions']);

        Permission::create(['name' => 'list webapps']);
        Permission::create(['name' => 'view webapps']);
        Permission::create(['name' => 'create webapps']);
        Permission::create(['name' => 'update webapps']);
        Permission::create(['name' => 'delete webapps']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
