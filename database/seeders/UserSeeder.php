<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Andi Saputra',
                'email' => 'andi@example.com',
                'phone_number' => '081234567891',
                'role' => 'user',
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'phone_number' => '081234567892',
                'role' => 'user',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone_number' => '081234567893',
                'role' => 'user',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'phone_number' => '081234567894',
                'role' => 'user',
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@example.com',
                'phone_number' => '081234567895',
                'role' => 'user',
            ],
            [
                'name' => 'Maya Anggraini',
                'email' => 'maya@example.com',
                'phone_number' => '081234567896',
                'role' => 'user',
            ],
            [
                'name' => 'Dimas Wijaya',
                'email' => 'dimas@example.com',
                'phone_number' => '081234567897',
                'role' => 'user',
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri@example.com',
                'phone_number' => '081234567898',
                'role' => 'user',
            ],
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus@example.com',
                'phone_number' => '081234567899',
                'role' => 'user',
            ],
            [
                'name' => 'Rina Wulandari',
                'email' => 'rina@example.com',
                'phone_number' => '081234567800',
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['phone_number' => $userData['phone_number']],
                array_merge($userData, ['password' => Hash::make('password123')])
            );
        }
    }
}
