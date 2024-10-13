<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Define the permissions needed for RolePolicy
        $permissions = [
            'view_any_role', 'view_role', 'create_role', 'update_role', 'delete_role',
            'delete_any_role', 'force_delete_role', 'force_delete_any_role',
            'restore_role', 'restore_any_role', 'replicate_role', 'reorder_role',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create or retrieve the admin role and assign all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // Create the admin user and assign the admin role
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password') // Set a secure password here
            ]
        );

        // Assign the admin role to the user
        $adminUser->assignRole($adminRole);
    }
}
