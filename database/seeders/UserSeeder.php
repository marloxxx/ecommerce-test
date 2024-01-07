<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin =  User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'active',
        ]);

        $admin->assignRole('admin');

        $user =  User::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'active',
        ]);

        $user->assignRole('user');
    }
}
