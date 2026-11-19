<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kamibantu.test',
            'password' => Hash::make('password'),
            'whatsapp_number' => '6281234567890',
            'role' => 'admin',
            'bio' => 'Platform administrator.',
        ]);
    }
}