<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // Make sure to import the Role model

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormData(array $data): array
    {
        // Check if user with the given email already exists
        $existingUser = User::where('email', $data['email'])->first();

        if (!$existingUser) {
            // If the user doesn't exist, create a new one
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Assign the role to the newly created user
            $user->assignRole($data['roles']); // Assuming 'roles' is passed in the form

            return $data; // Return the original data (or any other data if needed)
        } else {
            // Handle the case where the user already exists
            throw new \Exception('User with this email already exists.');
        }
    }
}
