<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Finance']);
        Role::firstOrCreate(['name' => 'Moderator']);
        Role::firstOrCreate(['name' => 'Support']);
        Role::firstOrCreate(['name' => 'Seller']);
        Role::firstOrCreate(['name' => 'Buyer']);
    }
}
