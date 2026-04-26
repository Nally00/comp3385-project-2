<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('Password1'),
            'location' => 'Antigua',
            'biography' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'photo' => 'demo/users/jane.jpg',
        ]); 

        User::create([
            'name' => 'Alex Miller',
            'email' => 'alex@gmail.com',
            'password' => Hash::make('Password2'),
            'location' => 'Jamaica',
            'biography' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'photo' => 'demo/users/alex.jpg' ,
        ]); 

    }
} 