<?php

namespace Database\Seeders;

use App\Enums\UserType;
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
        User::insert([
            [
                'name' => 'Test User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'user_type' => UserType::Admin->value
            ],
        ]);
    }
}
