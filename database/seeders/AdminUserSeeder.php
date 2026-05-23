<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'javier@gmail.com'],
            [
                'name' => 'Javier Admin',
                'password' => Hash::make('Admin$2026'),
                'is_admin' => true,
            ]
        );
    }
}
