<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminAndUserSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles exist
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'User']);
        Role::firstOrCreate(['name' => 'Assistant']);

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // Create Regular User
        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('User');

        $user = User::create([
            'name' => 'Assistant',
            'email' => 'assistant@assistant.com',
            'password' => bcrypt('12345'),
        ]);
        $user->assignRole('Assistant');
    }
}
