<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'User 1',
                'email' => 'user1@example.com',
                'phone' => '1234567891',
                'address' => '123 Main St',
                'gender' => 'male',
                'avatar' => 'user1.jpg',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@example.com',
                'phone' => '1234567892',
                'address' => '456 Elm St',
                'gender' => 'female',
                'avatar' => 'user2.jpg',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'User 3',
                'email' => 'user3@example.com',
                'phone' => '1234567893',
                'address' => '789 Oak St',
                'gender' => 'male',
                'avatar' => 'user3.jpg',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'User 4',
                'email' => 'user4@example.com',
                'phone' => '1234567894',
                'address' => '101 Pine St',
                'gender' => 'female',
                'avatar' => 'user4.jpg',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'User 5',
                'email' => 'user5@example.com',
                'phone' => '1234567895',
                'address' => '202 Birch St',
                'gender' => 'male',
                'avatar' => 'user5.jpg',
                'password' => Hash::make('password123'),
            ],
        ]);

    }
}

