<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pmui.com'],
            [
                'role_id' => 1, // Admin Role
                'name' => 'PMUI Administrator',
                'password' => Hash::make('Admin@123'),
            ]
        );
    }
}