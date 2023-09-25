<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin@test.com'),
            'role' => 2
        ]);

        // for ($i = 1; $i <= 40; $i++) {
        //     User::create([
        //         'name' => 'User ' . $i,
        //         'email' => 'user' . $i . '@test.com',
        //         'password' => Hash::make('password'),
        //         'role' => null // Assuming 1 represents regular users
        //     ]);
        // }
    }
}
