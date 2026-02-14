<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'テストユーザー',
            'phone' => '08000000000',
            'email' => 'user@example.com',
            'password' => Hash::make('user1234'),
            'role' => 'customer',       // 一般ユーザー
            'status' => 'active',   // 必要なら
        ]);
    }
}