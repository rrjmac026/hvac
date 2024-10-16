<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define the roles to be created
        $roles = ['Super_Admin', 'Admin', 'User', 'Veterinary', 'Assistant', 'Receptionist'];

        // Create roles if they don't already exist
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
