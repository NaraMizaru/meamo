<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['phone_number' => '081234567890'],
            [
                'name' => 'Admin Meamo',
                'email' => 'admin@meamo.com', // Optional
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
