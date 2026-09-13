<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'adminganteng890@example.com'],
            [
                'name' => 'AdminGanteng',
                'password' => Hash::make('samarinda123'),
                'role' => 'admin',
            ]
        );
    }
}
