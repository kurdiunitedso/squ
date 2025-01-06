<?php

namespace Database\Seeders;

use App\AppPermissionsHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create super-admin role
        $superAdminRole = Role::updateOrCreate(['name' => 'super-admin']);

        // Add impersonate permission to AppPermissionsHelper
        // Add this to your AppPermissionsHelper class in the getPermissions() method:
        $permissionModules = AppPermissionsHelper::getPermissions();

        // Add impersonation permission
        Permission::updateOrCreate(['name' => 'impersonate']);
        $this->command->info('impersonate permission added successfully!');

        foreach ($permissionModules as $key => $permissions) {
            foreach ($permissions as $permission) {
                Permission::updateOrCreate(['name' => $permission]);
                $this->command->info($permission . ' added successfully!');
            }
        }

        // Give all permissions to super-admin role
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);
    }
}
